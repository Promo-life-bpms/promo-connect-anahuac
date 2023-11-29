<div>
    <div class="z-50 fixed bottom-0 right-0 p-4 rounded-md">
        <div class="hidden transition-all" id="soporte" wire:ignore.self>
            <div class="flex flex-col justify-between bg-white shadow-2xl rounded-md" style="width: 350px; height: 550px">
                <div class="bg-primary h-16 pt-2 text-white flex justify-between items-center shadow-md p-2 rounded-md"
                    style="width: 350px">
                    <div class="my-3 text-green-100 font-bold text-lg tracking-wide">Soporte </div>
                    <div onclick="hideChat()" class="hover:cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                    </div>
                </div>
                <div class="overflow-y-auto h-full" id="chatWithSeller">
                    @if (count($messages) <= 0)
                        <p class="p-4 text-center">Da el primer paso.</p>
                    @endif
                    @foreach ($messages as $item)
                        @if ($item->receiver_id == auth()->user()->id)
                            <div class="clearfix">
                                <div class="bg-gray-200 w-3/4 mx-4 my-2 p-2 rounded-lg flex flex-wrap justify-between">
                                    <span class="text-sm">{{ $item->user->name }}</span>
                                    <p class="m-0 p-0 w-full break-words">
                                        {{ json_decode($item->message)->data }}
                                    </p>
                                    
                                    <span
                                        class="text-xs w-full text-right">{{ $item->is_read ==1? 'Leido:  '.  $item->updated_at->format('H:i')  :  'Enviado:  '. $item->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="clearfix">
                                <div
                                    class="bg-primary text-white float-right w-3/4 mx-4 my-2 p-2 rounded-lg clearfix flex flex-wrap justify-between">
                                    <span class="text-sm">Tú</span>
                                    <p class="m-0 p-0 w-full break-words">
                                        {{ json_decode($item->message)->data }}
                                    </p>
                                    <span
                                        class="text-xs w-full text-right">{{ $item->is_read ==1? 'Leido:  '.  $item->updated_at->format('H:i')  :  'Enviado:  '. $item->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="flex justify-between bg-white" style="bottom: 0px; width: 350px; rounded-md">
                    <textarea
                        class="flex-grow m-2 py-2 px-4 mr-1 rounded-full border border-gray-300 bg-gray-200 h-auto resize-y overflow-y-auto"
                        rows="1" placeholder="Message..." style="outline: none;" wire:keydown.enter='sendMessage'
                        wire:model='message'>
                    </textarea>
                    <button class="m-2" style="outline: none;" wire:click='sendMessage'>
                        <svg class="svg-inline--fa text-primary-dark fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2"
                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane"
                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="block transition-all" id="buttonSoporte" wire:ignore.self>
            <button onclick="showChat()"
                class="bg-primary hover:bg-primary-dark text-white font-bold rounded-full shadow-lg w-14 h-14 flex items-center justify-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                    </svg>
                </div>
            </button>
        </div>
    </div>
    <script>
        function showChat() {
            const chatElement = document.querySelector("#soporte")
            const buttonElement = document.querySelector("#buttonSoporte")
            chatElement.classList.remove('hidden')
            chatElement.classList.add('block')
            buttonElement.classList.remove('block')
            buttonElement.classList.add('hidden')
        }

        function hideChat() {
            const chatElement = document.querySelector("#soporte");
            const buttonElement = document.querySelector("#buttonSoporte");
            chatElement.classList.remove('block');
            chatElement.classList.add('hidden');
            buttonElement.classList.remove('hidden');
            buttonElement.classList.add('block');
        }

        window.addEventListener('downScroll', () => {
            var chat = document.getElementById('chatWithSeller');
            chat.scrollTop = chat.scrollHeight;
        })

        document.addEventListener('DOMContentLoaded', () => {
            var chat = document.getElementById('chatWithSeller');
            chat.scrollTop = chat.scrollHeight;
            chat.addEventListener("scroll", function() {
                if (chat.scrollTop === 0) {
                    // @this.totalMensajes = @this.totalMensajes + 2;
                }
            });
        })
    </script>
</div>
