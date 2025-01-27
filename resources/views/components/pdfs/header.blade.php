

<div class="grid grid-cols-3 gap-4 items-center text-center ">
    <div class="flex flex-col justify-center">
        <p>الجمهورية العربية السورية</p>
        <p>جامعة البعث</p>
        <p>كلية الهندسة المعلوماتية</p>
        <p>الرقم: {{ $id }}</p>
        <p>التاريخ: {{ $date }}</p>
    </div>
    <div class=" flex flex-row items-center justify-center align-middle">
        {{-- @dd(asset('imgs/albaath_logo.png')) --}}
        <img src="{{$logo}}" alt="logo" width="110px" height="110px">
    </div>
    <div class="flex flex-col justify-center">
        <p>Syrian Arab Republic</p>
        <p>Al-Baath University</p>
        <p> Factulty of Infrormatics Engineering </p>
        <p>N: {{ $id }} </p>
        <p>Date: {{ $date }}</p>
    </div>

</div>
