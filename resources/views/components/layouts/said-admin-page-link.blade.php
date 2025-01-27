 <div>

     <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">

         <li>
             <button type="button"
                 class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 aria-controls="dropdown-authentication" data-collapse-toggle="dropdown-authentication">

                 <span class="flex-1 ms-3 text-start whitespace-nowrap">
                    {{__("string.Authorization")}}
                </span>
                 <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                         d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                         clip-rule="evenodd"></path>
                 </svg>
             </button>
             <ul id="dropdown-authentication" class="hidden py-2 space-y-2">
                 <li>
                     <a href="{{ Route('admin.auth.permission') }}"
                         class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        {{__("string.Permissions")}}
                        </a>
                 </li>
                 <li>
                     <a href="{{ Route('admin.auth.role') }}"
                         class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                         {{__("string.Roles")}}
                        </a>
                 </li>
                 <li>
                     <a href="{{ Route('admin.auth.user') }}"
                         class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                         {{__("string.Users")}}
                        </a>
                 </li>
             </ul>
         </li>

     </ul>
     <!--  request section link -->
     <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">

         <li>
             <button type="button"
                 class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 aria-controls="dropdown-requests" data-collapse-toggle="dropdown-requests">

                 <span class="flex-1 ms-3 text-start whitespace-nowrap"> {{ __("string.Manage requests") }} </span>
                 <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                         d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                         clip-rule="evenodd"></path>
                 </svg>
             </button>
             <ul id="dropdown-requests" class="hidden py-2 space-y-2">
                 <li>
                     <a href="{{ Route('admin.requests.type') }}"
                         class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                         {{ __("string.Request type") }}
                        </a>
                 </li>
                 <li>
                     <a href="{{ Route('admin.requests.requset') }}"
                         class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                         {{ __("string.Requests") }}
                        </a>
                 </li>

             </ul>
         </li>

     </ul>


     <!-- employee section  link -->
     <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">

         <li>
             <button type="button"
                 class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 aria-controls="dropdown-employees" data-collapse-toggle="dropdown-employees">

                 <span class="flex-1 ms-3 text-start whitespace-nowrap">
                     {{ __("string.Manage employees") }}
                 </span>
                 <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                         d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                         clip-rule="evenodd"></path>
                 </svg>
             </button>
             <ul id="dropdown-employees" class="hidden py-2 space-y-2">
                 <li>
                     <a href="{{ Route('admin.employee.department') }}"
                         class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                         {{ __("string.Departments")}}
                     </a>
                 </li>
                 <li>
                     <a href="{{ Route('admin.employee.employee') }}"
                         class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                         {{ __("string.Employees") }}
                        </a>
                 </li>

             </ul>
         </li>

     </ul>

     <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
         <li>
             <a href="{{ Route('admin.collage_information') }}"
                 class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                 <span class="ml-3">
                    {{ __("string.Collage informations")}}
                </span>
             </a>
         </li>

         <li>
             <a href="./staticties.html"
                 class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                 <span class="ml-3">
                    {{ __("string.Staticties") }}
                 </span>
             </a>
         </li>
         <li>
            <a href="{{Route('admin.backups')}}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                <span class="ml-3">
                   {{ __("string.Backups") }}
                </span>
            </a>
        </li>

     </ul>
 </div>
