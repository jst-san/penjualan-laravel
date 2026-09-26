<x-app>
    <div class="max-w-7xl mx-auto py-8">
        <span class="text-slate-600 space-x-1 px-8">
            <a href="/transaksi" class="hover:text-blue-500 active:text-blue-500">Transaksi</a>
            <span>\</span>
            <span class="text-blue-500">Buat</span>
        </span>
    </div>
    <div class="max-w-3xl mx-auto pb-32 relative">
        <div id="success_notification" class="sticky top-20 bg-blue-300 p-4 mb-4 rounded-md text-lg text-blue-500 hidden">
        </div>
        <div id="barang-container" class="flex flex-col">
            {{-- <BarangCard/> --}}
        </div>
    </div>
    <div class="fixed bottom-0 w-full p-4 bg-white border-t border-slate-200">
        <div class="w-full space-y-4">
            <div>
                <p class="text-xl"><span id="transaksi-jumlah_barang" class="text-blue-500">0</span> Item Dipilih</p>
            </div>
            <div class="flex gap-4 justify-end">
                <div>
                    <p class="text-right text-sm">Total: </p>
                    <p id="transaksi-total" class="text-right text-xl text-blue-500">Rp0</p>
                </div>
                <button type="button"
                    class="px-5 py-2.5 rounded text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-600"
                    onclick="submit()">
                    Buat Transaksi
                </button>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        let total = 0;
        let jumlah_barang;
        let barangs = [];
        let timer = null;
        let delay = null;

        async function getBarangs() {
            const res = await fetch('/api/barang').then((r) => r.json());

            if (res.success) {
                barangs = res.data.map((d) => ({...d,harga: Number(d.harga), qty: 0, subtotal: 0}));
            } else {
                alert('Terjadi masalah!');
            }
        }

        function renderBarangs() {
            const container = document.getElementById('barang-container');
            if (!barangs) return console.log('barang kosong');

            container.innerHTML = '';
            barangs.forEach((b) => {
                const {id, kode_barang,nama_barang, harga, stok, qty, subtotal} = b;

                container.innerHTML += `
                <div id="brg-${id}" class="last:border-b-0 p-4 border-b border-slate-100 flex flex-col gap-4">
                    <div class="flex flex-col">
                        <p class="text-xs text-slate-300 px-1.5 bg-slate-100 w-max rounded-full border">${kode_barang}</p>
                        <h2 class="text-xl mt-2">${nama_barang}</h2>
                        <p class="text-blue-500 text-xl">Rp${harga.toLocaleString('ID-id')},00</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <span>Stok: </span>
                            <span class="text-blue-500">${stok}</span>
                        </div>
                        <div class="flex">
                            <div id="brg-${id}-subtotal" class="text-blue-500 mr-2">Rp${subtotal.toLocaleString("ID-id")},00</div>
                            <button class="p-1 text-slate-600 bg-slate-100/50 hover:bg-slate-100/80 active:bg-slate-100"
                                onclick="decrease(${id})"
                                onmousedown="start(${id},'decrease')"
                                onmouseup="stop()"
                                onmouseleave="stop()"
                                ontouchstart="start(${id},'decrease')"
                                ontouchend="stop()"
                            >
                                <svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="inherit"
                                class="bi bi-dash" viewBox="0 0 \`6 16"
                                >
                                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                </svg>
                            </button>
                            <div id="brg-${id}-qty" class="grid place-content-center w-6 h-6 p-2 text-slate-600 text-sm bg-slate-100/50 leading-4">${qty}</div>
                            <button class="p-1 text-slate-600 bg-slate-100/50 hover:bg-slate-100/80 active:bg-slate-100"
                                onclick="increase(${id})"
                                onmousedown="start(${id},'increase')"
                                onmouseup="stop()"
                                onmouseleave="stop()"
                                ontouchstart="start(${id},'increase')"
                                ontouchend="stop()"
                            >
                                <svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="inherit"
                                class="bi bi-plus" viewBox="0 0 16 16"
                                >
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="brg-${id}-error" class="col-span-2 w-full p-4 bg-red-200 text-red-500 rounded border hidden"></div>
                </div>
                `
            })
        }

        function increase(id) {
            const target = barangs.find((b) => b.id === id);

            if (!target) return;

            if (target.qty === target.stok) return;

            target.qty++;
            target.subtotal += target.harga;
            total+=target.harga;

            barangs = barangs.map((b) => b.id === id ? target : b);

            document.getElementById(`brg-${id}-qty`).innerText = target.qty;
            document.getElementById(`brg-${id}-subtotal`).innerText = `Rp${target.subtotal.toLocaleString("ID-id")},00`;
            calculateTransaksi();
        }

        function decrease(id) {
            const target = barangs.find((b) => b.id === id);

            if (!target) return;

            if (target.qty === 0) return;

            if (target.qty - 1 === target.stok) {
                const errorMessage = document.getElementById(`brg-${id}-error`);
                if (errorMessage.dataset.error = 'STOK_EXCEEDED') errorMessage.classList.add('hidden');
            }

            target.qty--;
            target.subtotal -= target.harga;
            total-=target.harga;

            barangs = barangs.map((b) => b.id === id ? target : b);

            document.getElementById(`brg-${id}-qty`).innerText = target.qty;
            document.getElementById(`brg-${id}-subtotal`).innerText = `Rp${target.subtotal.toLocaleString("ID-id")},00`;
            calculateTransaksi();
        }

        function calculateTransaksi() {
            total = barangs.reduce((a, c) => a + c.qty * c.harga, 0);
            document.getElementById('transaksi-total').innerText = `Rp${total.toLocaleString("ID-id")},00`;
            jumlah_barang = barangs.reduce((a, c) => a + c.qty, 0);
            document.getElementById('transaksi-jumlah_barang').innerText = jumlah_barang;
        }

        function start(id, action = 'increase') {
            stop();
            if (timer !== null) return;

            delay = setTimeout(() => {
                timer = setInterval(() => action === 'increase' ? increase(id) : decrease(id), 100);
            }, 500);
        }

        function stop() {
            clearTimeout(delay);
            delay = null;

            clearInterval(timer);
            timer = null;
        }

        async function handleError(errors) {
            await getBarangs();
            renderBarangs();
            errors.forEach((e) => {
                const errorMessage = document.getElementById(`brg-${e.id}-error`);
                errorMessage.innerText = e.message;
                errorMessage.dataset.error = e.status;
                errorMessage.classList.remove('hidden');
            })
        }

        async function mount() {
            await getBarangs();
            renderBarangs();
        }

        async function submit() {
            const res = await fetch('/api/transaksi', {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    items: barangs.map((b) => ({id: b.id, qty: b.qty})).filter((b) => b.qty)
                })
            }).then((r) => r.json());

            if (res.errors || !res.success) {
                return handleError(res.errors);
            }

            await getBarangs();
            renderBarangs();
            calculateTransaksi();
            const notif = document.getElementById('success_notification');
            notif.classList.remove('hidden');
            notif.innerText = res.message;

            setTimeout(() => {
                notif.classList.add('hidden');
                notif.innerText = '';
            }, 3000)
        }

        mount();
    </script>
</x-app>
