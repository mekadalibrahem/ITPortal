<?php

namespace App\Classes\Export;

use App\Models\RequestList;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Masmerise\Toaster\Toaster;
use MSA\LaravelGrapes\Models\Page;
use Spatie\Browsershot\Browsershot;

class BrowserShotExportRequest extends AbstractExportRequest
{
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
        $array = $this->add_request_data($array);
        $array = $this->add_request_steps($array);

        return $array;
    }
    public function get_view()
    {
        $current_page = $this->request->page;
        $original_page = $this->request->requests->page;
        $page = $current_page ? $current_page : $original_page;
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
            $browsershot = Browsershot::html($view)
                ->setNodeBinary('/home/mekad/.nvm/versions/node/v22.14.0/bin/node')
                ->setNpmBinary("/home/mekad/.nvm/versions/node/v22.14.0/bin/npm")
                // ->baseUrl(config('app.url'))
                ->format('A4')
                ->waitUntil('domcontentloaded'); // Use domcontentloaded instead of networkidle0
            // ->timeout(90000) // Increase to 90 seconds
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
