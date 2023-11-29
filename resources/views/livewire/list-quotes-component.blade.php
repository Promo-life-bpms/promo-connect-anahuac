<div class="container mx-auto max-w-7xl py-2">
    <div class="bg-white container mx-auto max-w-7xl grid-cols-2 md:px-28 lg:px-72">
        @if (count($quotes) > 0)
            <table class="min-w-full text-left text-sm ">
                <thead class="border-b border-current">
                    <tr>
                        <th scope="col" class="pt-2 md:pl-3">
                            <span class="text-lg"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 block mb-1"
                                    style="display: inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                                </svg> MIS COMPRAS</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotes as $quote)
                        <tr class="border-b border-current">
                            <td class="pl-5 md:pl-8">
                                <span>ODC-{{ $quote->id }}</span>
                                <br />
                                @if ($quote->latestQuotesUpdate)
                                    @if ($quote->latestQuotesUpdate->quoteProducts)
                                        @if (count($quote->latestQuotesUpdate->quoteProducts) > 0)
                                            <span class="text-center">$
                                                {{ $quote->latestQuotesUpdate->quoteProducts->sum('precio_total') }}
                                            </span><br />
                                        @endif
                                    @endif
                                @endif
                                <span class="text-center">
                                    {{ $quote->latestQuotesUpdate->created_at->format('d-m-Y') }}</span>
                            </td>
                            <td class="font-medium flex justify-center ">
                                <a href="{{ route('verCotizacion', ['quote' => $quote->id]) }}" class="btn-sm"><button
                                        class="bg-primary hover:bg-primary-dark px-10 py-2  text-white">Ver
                                        Compra</button></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{ $quotes->links() }}
            </div>
        @else
            <div class="flex w-100 justify-center">
                <strong class="text-center m-0 my-5">No tienes compras realizadas.</strong>
            </div>
        @endif
    </div>
</div>
