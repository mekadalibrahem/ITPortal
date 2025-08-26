<?php

namespace App\Classes\Export;

use App\Models\Department;
use App\Models\RequestList;
use App\Traits\HasConvertImageToBase64;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Masmerise\Toaster\Toaster;
use Spatie\Browsershot\Browsershot;

class BrowserShotExportRequest extends AbstractExportRequest
{
    use HasConvertImageToBase64;
    protected GrapesJsTemplateRenderer $renderer;

    public function __construct(GrapesJsTemplateRenderer $renderer, RequestList $request)
    {
        $this->renderer = $renderer;
        parent::__construct($request);
    }

    public function init_data(): array
    {
        $user = $this->request->user;
        $array = [
            "id" => $this->request->id,
            "date" => $this->request->created_at,
            "fullname" => $user->fullname(),
            "username" => $user->fname . " " . $user->lname,
            "name" => $user->fname,
            // father name  => mname
            "fname" => $user->mname,
            "lname" => $user->mname,
            "user_nid" => $user->nid,
            "user_sig" => $user->signature,
            'title' => $this->request->requests->name


        ];
        $array = $this->add_department_stamps($array);

        $array = $this->add_request_data($array);
        $array = $this->add_request_steps($array);

        return $array;
    }
    public function add_department_stamps($array)
    {
        $department_id =  array_unique(RequestList::where('request_lists.id', '=', $this->request->id)
            ->join('request_logs', 'request_logs.request_list_id', '=', 'request_lists.id')
            ->join('request_tamplates_steps', 'request_tamplates_steps.id', '=', 'request_logs.request_tamplates_step_id')
            ->select([
                'request_lists.id',
                'request_logs.request_list_id',
                'request_tamplates_steps.id',
                'request_logs.request_tamplates_step_id',
                'request_tamplates_steps.department_id'
            ])
            ->get()->pluck('department_id')->toArray());

        $department_stamps = Department::whereIn('id', $department_id)->select(['id', 'stamp'])->get();



        foreach ($department_stamps as $item) {


            $array['stamp_' . $item->id] = $this->storage2base64(Storage::disk('stamps')->get( $item->stamp), $item->stamp);
        }
        return $array;
    }
    public function get_view()
    {
        $current_page = $this->request->page;
        $page =  $current_page ?? $this->request->requests->page;
        if (!$page) {
            Toaster::error(trans("messages.print template not set yet"));
            throw new  Exception("FAILD GET VIEW PRINT TEMPLATE NOT SET YET");
            return null;
        }
        $renderedContent = $this->renderer->render($page, $this->init_data());
        return View::make('export.template', [
            'htmlContent' => $renderedContent['htmlContent'],
            'cssContent' => $renderedContent['cssContent']
        ])->render();
    }

    public function export()
    {


        try {
            $view = $this->get_view();
            $file_name = $this->request->user->id . "_" . $this->request->requests->name . "_" . $this->request->id . "_" . time() . ".pdf";
            $browsershot = Browsershot::html($view);
            
            if (!empty(config("browsershot.node_path", ''))) {
                $browsershot->setNodeBinary(config("browsershot.node_path", ''));
            }
            if (!empty(config("browsershot.npm_path", ''))) {
                $browsershot->setNpmBinary(config("browsershot.npm_path", ''));
            }
            $browsershot->format('A4')
                // ->baseUrl(config('app.url'))
                ->waitUntil('domcontentloaded') // Use domcontentloaded instead of networkidle0
                ->timeout(90000); // Increase to 90 seconds
            // ->showBrowserOutput(); // Enable debug output

            // Disable JavaScript if not needed
            // $browsershot->noJavaScript();

            // Increase memory limit for Puppeteer
            $browsershot->setExtraExecutionArgs(['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage', '--memory-pressure-off']);

            $browsershot->savePdf($file_name);
            return response()->download($file_name)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            Log::error('PDF Generation failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Failed to generate PDF.'], 500);
        }
    }

    private function add_request_data($array): array
    {

        foreach ($this->request->data as $item) {

            $array[$item->name] = $item->value;
        }
        return $array;
    }
    private function add_request_steps($array)
    {

        $step_count = 1;
        foreach ($this->request->requestLog as $item) {

            $user = $item->employee->user;
            $array["step_" . $step_count] = [
                'name' => $user->fullname(),
                'sig' => $user->signature,
            ];
            $step_count++;
        }
        return $array;
    }
}
