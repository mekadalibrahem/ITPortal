<div class=" min-w-16 w-auto" >
    <form action="{{Route('language.switch')}}" method="POST">
        @csrf
        <select name="language" onchange="this.form.submit()" class="  bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >

            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }} > en</option>
            <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }} > ar </option>

        </select>
    </form>
</div>



