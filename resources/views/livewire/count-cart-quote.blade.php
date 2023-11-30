<div>
    <a class="cart-icon nav-link text-black hover:text-primary " aria-current="page" href="{{ route('cotizacion') }}" data-toggle="tooltip"
        data-placement="bottom" title="Cotizacion Actual" >
        <div class="ml-2 mr-2 mt-4">
            @if ($total > 0)
                <span class="absolute inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-primary-dark border-1  rounded-full -top-2 -right-2" >{{ $total }}</span>
            @endif
            <svg width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                <defs>
                <style>.cls-1{fill:none;stroke:#FF5900;stroke-miterlimit:10;stroke-width:1.91px;}</style>
                </defs>
                <g id="cart">
                <circle class="cls-1" cx="10.07" cy="20.59" r="1.91"/>
                <circle class="cls-1" cx="18.66" cy="20.59" r="1.91"/>
                <path class="cls-1" d="M.52,1.5H3.18a2.87,2.87,0,0,1,2.74,2L9.11,13.91H8.64A2.39,2.39,0,0,0,6.25,16.3h0a2.39,2.39,0,0,0,2.39,2.38h10"/>
                <polyline class="cls-1" points="7.21 5.32 22.48 5.32 22.48 7.23 20.57 13.91 9.11 13.91"/>
                </g>
                
            </svg>
        </div>

    </a>
    <style>
        .cart-icon .badge {
            position: relative;
            top: 20px;
            right: 10px;
        }

        .cart-icon {
            position: relative;
        }

        @media(min-width:768px) {
            .cart-icon .badge {
                position: initial;
            }
        }
    </style>
</div>
