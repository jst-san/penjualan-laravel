<header
    class="sticky z-999 inset-0 w-full h-20 px-8 bg-white border-b border-b-slate-200 flex items-center justify-between">
    <a href="/" class="w-12 h-12 grid place-content-center bg-linear-to-tr from-blue-500 to-violet-400 bg-clip-text text-transparent text-2xl">
      RPL
    </a>

    <nav class="hidden md:flex gap-8 items-center">
        @foreach ($routes as $route)
            <a href="{{ $route->href }}" class="text-slate-600 hover:text-blue-500 active:text-blue-500 transition-colors">{{ $route->label }}</a>
        @endforeach
    </nav>

    <button class="md:hidden w-6 h-6 relative" onclick="toggle()">
        <hr class="absolute top-1 -left-1 w-6 h-0 border-y border-slate-600 rounded-full transition-all" id="top-line" />
        <hr class="absolute bottom-1 -right-1 w-6 h-0 border-y border-slate-600 rounded-full transition-all"
            id="bottom-line" />
    </button>
    <div id="dropdown"
        class="md:hidden absolute z-999 top-full left-0 w-full flex flex-col bg-white border-slate-200 rounded-b-md overflow-hidden max-h-0 duration-300">
        @foreach ($routes as $route)
            <a href="{{ $route->href }}"
                class="py-4 px-8 w-full text-slate-600 hover:bg-slate-100 active:bg-slate-100 hover:text-blue-500 active:text-blue-500 transition-colors">{{ $route->label }}</a>
        @endforeach
    </div>

    <script type="application/javascript">
        let isOpen = false;
        const topl = document.getElementById("top-line");
        const bottoml = document.getElementById("bottom-line");
        const dropdown = document.getElementById("dropdown");
        
        function toggle(value = null) {
            isOpen = value !== null ? value : !isOpen;
            handleChange();
        };

        function handleChange() {
            const topClass =  ["rotate-45", "top-1/2!", "left-1/2!", "-translate-1/2"];
            const bottomClass = ["-rotate-45", "bottom-1/2!", "right-1/2!", "translate-1/2"];
            const dropdownClass = ["pb-2", "border-b", "max-h-44!"];
            if (isOpen) {
                topClass.forEach((c) => {
                    topl.classList.add(c);
                });

                bottomClass.forEach((c) => {
                    bottoml.classList.add(c);
                })

                dropdownClass.forEach((c) => {
                    dropdown.classList.add(c);
                })
            } else {
                topClass.forEach((c) => {
                    topl.classList.remove(c);
                });

                bottomClass.forEach((c) => {
                    bottoml.classList.remove(c);
                })

                dropdownClass.forEach((c) => {
                    dropdown.classList.remove(c);
                })
            };
        }
    </script>
</header>
