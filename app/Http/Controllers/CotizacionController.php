<?php

namespace App\Http\Controllers;

use App\Models\CurrentQuoteDetails;
use App\Models\Quote;
use App\Models\QuoteTechniques;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;  
use Illuminate\Support\Facades\File;
use ZipStream\Option\Archive;

class CotizacionController extends Controller
{
    public function generarPDF(){
    
        $date =  Carbon::now()->format("d/m/Y");

        $cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;
        $totalQuote = 0;

        foreach ($cotizacionActual as $productToSum) {
            if ($productToSum->quote_by_scales) {
                try {
                    $totalQuote = $totalQuote + floatval(json_decode($productToSum->scales_info)[0]->total_price);
                } catch (Exception $e) {
                    $totalQuote = $totalQuote + 0;
                }
            } else {
                $totalQuote = $totalQuote + $productToSum->precio_total;
            }
        }

        $total = $totalQuote;
        if (auth()->user()->currentQuote->type == 'Fijo') {
            $discountMount = auth()->user()->currentQuote->value;
        } else {
            $discountMount = round((($totalQuote / 100) * auth()->user()->currentQuote->value), 2);
        }
        $discount = $discountMount;
        
        $cotizacionActual = auth()->user()->currentQuote->currentQuoteDetails;
        
     /*    $pdf = \PDF::loadView('pages.pdf.cotizacionBH', ['date' =>$date, 'cotizacionActual'=>$cotizacionActual ]);
        $pdf->setPaper('Letter', 'portrait');
        return $pdf->stream("QS-1". '.pdf');  */

        $pdf = \PDF::loadView('pages.pdf.cotizacionBH', ['date' => $date, 'cotizacionActual' => $cotizacionActual]);
        $pdf->setPaper('Letter', 'portrait');
        $filename = "QS-1.pdf";
        $pdf->save(public_path($filename));

        return response()->download(public_path($filename))->deleteFileAfterSend(true);
        
    }

    public function downloadPDF(Request $request)
    {

        $date =  Carbon::now()->format("d/m/Y");

        $user = auth()->user();
        $quotes = Quote::where('user_id', $user->id)->where('id',$request->id)->get();
        
       /*  dd($quotes[0]->currentQuotesTechniques); */
        
        $pdf = \PDF::loadView('pages.pdf.quoteBH', ['date' => $date, 'quotes' => $quotes]);
        $pdf->setPaper('Letter', 'portrait');
        $filename = "Cotizacion.pdf";
        $pdf->save(public_path($filename));
   
        return response()->download(public_path($filename))->deleteFileAfterSend(true);
        
    }
}
