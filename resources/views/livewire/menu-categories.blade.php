<div>
    <button id="dropdownHoverButton" data-dropdown-toggle="dropdown2"
        class=" p-1 font-medium focus:rounded text-lg text-center inline-flex items-center border border-white ml-8"
        type="button">
        <svg viewBox="0 0 600 600" version="1.1" id="svg9724" sodipodi:docname="menu.svg" inkscape:version="1.2.2 (1:1.2.2+202212051550+b0a8486541)" width="18px" height="18px" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
            <defs id="defs9728" />
                <g id="g10449" transform="matrix(0.95173205,0,0,0.95115787,13.901174,12.168794)" style="stroke-width:1.05103">
                    <g id="path10026" inkscape:transform-center-x="-0.59233046" inkscape:transform-center-y="-20.347403" transform="matrix(1.3807551,0,0,1.2700888,273.60014,263.99768)" />
                    <g id="g11314" transform="matrix(1.5092301,0,0,1.3955555,36.774048,-9.4503933)" style="stroke-width:50.6951" />
                        <path style="color:#FFFFFF;fill:#FFFFFF;stroke-width:1.05104;stroke-linecap:square;stroke-linejoin:round;-inkscape-stroke:none;paint-order:stroke fill markers"
                            d="m 116.82051,533.90848 c 0,-35.77923 -30.001428,-65.78273 -65.71225,-65.78274 -35.710867,10e-6 -65.714445,30.00351 -65.714445,65.78274 0,35.7791 30.003578,65.78265 65.714445,65.78265 35.710822,0 65.71225,-30.00355 65.71225,-65.78265 z"
                            id="path1237" />
                        <path
                            style="color:#FFFFFF;fill:#FFFFFF;stroke-width:1.05104;stroke-linecap:square;stroke-linejoin:round;-inkscape-stroke:none;paint-order:stroke fill markers"
                            d="m 116.82051,302.6125 c 0,-35.77918 -30.001428,-65.78266 -65.71225,-65.78267 -35.710867,1e-5 -65.714445,30.00349 -65.714445,65.78267 2.6e-5,35.77922 30.003597,65.78043 65.714445,65.78045 35.710806,-2e-5 65.71224,-30.00123 65.71225,-65.78045 z"
                            id="path1235" />
                        <path
                            style="color:#FFFFFF;fill:#FFFFFF;stroke-width:1.05104;stroke-linecap:square;stroke-linejoin:round;-inkscape-stroke:none;paint-order:stroke fill markers"
                            d="m 116.82051,71.313209 c 0,-35.779199 -30.001428,-65.7804582 -65.71225,-65.7804662 -35.710867,8e-6 -65.714445,30.0012672 -65.714445,65.7804662 0,35.779271 30.003578,65.782741 65.714445,65.782751 35.710822,-1e-5 65.71225,-30.00348 65.71225,-65.782751 z"
                            id="path346" />
                        <path
                            style="color:#FFFFFF;fill:#FFFFFF;stroke-width:1.05103;stroke-linecap:round;-inkscape-stroke:none"
                            d="m 211.58808,21.527961 a 47.572886,49.785578 0 0 0 -47.57256,49.787552 47.572886,49.785578 0 0 0 47.57256,49.785227 H 568.24859 A 47.572886,49.785578 0 0 0 615.82336,71.315513 47.572886,49.785578 0 0 0 568.24859,21.527961 Z"
                            id="path1011" />
                        <path
                            style="color:#FFFFFF;fill:#FFFFFF;stroke-width:1.05103;stroke-linecap:round;-inkscape-stroke:none"
                            d="m 211.58808,252.82616 a 47.572886,49.785578 0 0 0 -47.57256,49.78524 47.572886,49.785578 0 0 0 47.57256,49.78523 h 356.66051 a 47.572886,49.785578 0 0 0 47.57477,-49.78523 47.572886,49.785578 0 0 0 -47.57477,-49.78524 z"
                            id="path1011-7" />
                        <path
                            style="color:#FFFFFF;fill:#FFFFFF;stroke-width:1.05103;stroke-linecap:round;-inkscape-stroke:none"
                            d="m 211.58808,484.1232 a 47.572886,49.785578 0 0 0 -47.57256,49.78523 47.572886,49.785578 0 0 0 47.57256,49.78524 h 356.66051 a 47.572886,49.785578 0 0 0 47.57477,-49.78524 47.572886,49.785578 0 0 0 -47.57477,-49.78523 z"
                            id="path1011-5" />
                </g>
        </svg>
        
        <p class="text-md ml-3 mt-1 mb-1">Categorías</p>
        <svg class="w-4 h-4 ml-2 mr-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div id="dropdown2" class="z-40 hidden bg-[#002A4C] divide-y divide-gray-100 rounded-lg shadow w-44  hover:text-[#009CDE]">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">

            @foreach($latestCategorias as $category )
                <li class="mt-4 mb-4  p-2 hover:bg-white">
                    <a href="{{ route('categoryfilter', ['category' => $category->id]) }}"
                        class="bg-[#161B2F] font-bold text-white uppercase m-4 ">
                                {{ $category->family }}
                    </a>
                </li>
            @endforeach
            
        </ul>
    </div>
    
</div>

