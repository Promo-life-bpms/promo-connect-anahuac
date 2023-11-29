<div class="px-2 h-full">
    <div class="w-full bg-white h-full">
        <div class="container mx-auto max-w-7xl py-2 h-full">
            <h5 class="text-3xl py-4 font-semibold">Soporte a compradores</h5>
            <div
                class="flex w-full text-center bg-white border border-gray-200 rounded-xl shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-wrap w-full">
                    <div class="w-1/4 bg-white py-2 px-3 text-left border-b border-r rounded-tl-xl border-gray-400/50">
                        <h1 class="text-2xl font-bold">Compradores</h1>
                    </div>
                    <div class="w-3/4 bg-white py-2 px-3 text-left border-b rounded-tr-xl border-gray-400/50">
                        <h1 class="text-2xl font-bold">
                            {{ $userSelected ? $userSelected->name : 'Seleccionar Conversación' }}
                        </h1>
                    </div>
                    <div class="w-1/4 overflow-y-scroll h-[60vh] text-left border-r border-slate-200">

                        <input type="text" class="w-full"  wire:model="search" placeholder="Buscar usuario...">
                        
                        <div class="">
                            @foreach ($userMessages as $message)
                                @foreach($usersWithMessage as $user)
                                    @if($message->client_id == $user->id )
                                        <div class="flex items-center gap-2 px-4 py-2 border-b hover:bg-slate-100 hover:cursor-pointer {{ $userSelected ? ($userSelected->id == $user->id ? 'bg-slate-200' : '') : '' }}"
                                        wire:click='seccionarChat({{ $user->id}})'>
                                        <div
                                            class="shadow-sm rounded-full h-10 w-10 border font-bold border-blue-500 flex justify-center items-center text-xl p-4">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                            <div>
                                                <p class="m-0 p-0 font-semibold">{{ $user->name }}</p>
                                                <div class="flex">
                                                    
                                                        <p class="w-48 {{ $message->is_read == 0 ? 'font-bold' : '' }}">
                                                            {{ \Illuminate\Support\Str::limit(json_decode($message->message)->data, 20, '...') }}
                                                        </p>
                                                        <p class="{{ $message->is_read == 0 ? 'font-bold' : '' }}">{{$message->created_at->format('H:i') }}</p>
                                                    
                                                </div>
                                              
                                                
                                            </div>
                                        </div>

                                    @endif

                                @endforeach
                                
                            @endforeach
                            <div class="bg-zinc-300	p-2 ">
                                <p class="text-center font-bold"> Más usuarios </p>
                            </div>
                           
                            @foreach ($usersWithoutMessage as $user)
                               
                                <div class="flex items-center gap-2 px-4 py-2 border-b hover:bg-slate-100 hover:cursor-pointer {{ $userSelected ? ($userSelected->id == $user->id ? 'bg-slate-200' : '') : '' }}"
                                wire:click='seccionarChat({{ $user->id }})'>
                                <div
                                    class="shadow-sm rounded-full h-10 w-10 border font-bold border-blue-500 flex justify-center items-center text-xl p-4">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                    <div>
                                        <p class="m-0 p-0 font-semibold">{{ $user->name }}</p>
                                        <p>
                                        
                                        </p>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    <div class="w-3/4 bg-white">
                        <div class="p-4">
                            <div class="overflow-y-auto h-[48vh]" id="chatWithUser">
                                @if (!$userSelected)
                                    <p class="p-4 text-center">Selecciona un Contacto</p>
                                @else
                                    @if (count($messages) <= 0)
                                        <p class="p-4 text-center">Da el primer paso.</p>
                                    @endif
                                    @foreach ($messages as $item)
                                        @if ($item->receiver_id == auth()->user()->id)
                                            <div class="clearfix">
                                                <div
                                                    class="text-left bg-gray-200 w-3/4 mx-4 my-2 p-2 rounded-lg flex flex-wrap justify-between">
                                                    <p class="m-0 p-0 w-full">
                                                        {{ json_decode($item->message)->data }}
                                                    </p>
                                                    <span
                                                        class="text-xs w-full text-right">{{ $item->created_at->format('H:i') }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="clearfix">
                                                <div
                                                    class="text-left bg-blue-500 text-white float-right w-3/4 mx-4 my-2 p-2 rounded-lg clearfix flex flex-wrap justify-between">
                                                    <p class="m-0 p-0 w-full">
                                                        {{ json_decode($item->message)->data }}
                                                    </p>
                                                    <span
                                                        class="text-xs w-full text-right">{{ $item->created_at->format('H:i') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="p-4 w-full flex justify-between bg-white rounded-md" style="bottom: 0px; ">
                            @if ($userSelected)
                                <textarea class="flex-grow m-2 py-2 px-4 mr-1 rounded-full border border-gray-300 bg-gray-200 resize-none"
                                    rows="1" placeholder="Message..." style="outline: none;" wire:keydown.enter='sendMessage'
                                    wire:model='message'>  </textarea>
                                <button class="m-2" style="outline: none;" wire:click='sendMessage'>
                                    <svg class="svg-inline--fa text-primary-dark fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2"
                                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane"
                                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                            d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('downScroll', () => {
            var chat = document.getElementById('chatWithUser');
            chat.scrollTop = chat.scrollHeight;
        })

        document.addEventListener('DOMContentLoaded', () => {
            var chat = document.getElementById('chatWithUser');
            chat.scrollTop = chat.scrollHeight;
            chat.addEventListener("scroll", function() {
               /*  if (chat.scrollTop === 0) {
                    @this.totalMensajes = @this.totalMensajes + 2;
                } */
            });
        })
    </script>
</div>
