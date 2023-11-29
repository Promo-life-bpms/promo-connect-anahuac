<?php

namespace App\Http\Livewire;

use App\Models\CommentsSupport;
use App\Models\Muestra;
use App\Models\Quote;
use App\Models\Role;
use App\Models\User;
use App\Notifications\StatusPedidoNotification;
use Livewire\Component;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class VerCotizacionComponent extends Component
{

    use AuthorizesRequests;

    public $quote, $puedeEditar = false, $quoteStatus;

    public $newQuoteInfo = [];
    public $datos = [];
    public $showProduct;

    public $comentario, $seller_id, $received_id;
    public $id_proceso_compra;
    public $user;
    public $id_compra, $id_muestra;
    public $messagesnuevos = [];
    public $message;
    protected $listeners = [
        'updateQuoteInfo' => 'updateQuoteInfo',
        'echo:real-time,ChatEvent' => 'recibio',
    ];

    public function mount()
    {
        $this->quoteStatus = $this->quote->status;
    }

    public function render()
    {
        $comments = CommentsSupport::join('users', 'users.id', 'comments_supports.user_id')
            ->join('role_user', 'role_user.user_id', 'users.id')
            ->where('id_proceso_compra', $this->quote->id)
            ->where('type_proceso_compra', 'compra')
            ->select(
                'comments_supports.created_at',
                'comments_supports.message',
                'users.name',
                'role_user.role_id'
            )
            ->get();

        $products = $this->quote->latestQuotesUpdate->quoteProducts;

        return view('livewire.ver-cotizacion-component', ["products" => $products, "comments" => $comments]);
    }

    public function editar()
    {
        $this->authorize('update', $this->quote);
        $this->puedeEditar = !$this->puedeEditar;
        $this->emit('puedeEditar', ['puedeEditar' => $this->puedeEditar]);
    }

    public function updateQuoteInfo($quoteInfo)
    {
        $this->authorize('update', $this->quote);
        $this->newQuoteInfo = $quoteInfo;
        $this->dispatchBrowserEvent('Editarcliente');
    }

    public function addMessage()
    {
        $this->validate([
            'message' => 'required',
        ]);

        $this->messagesnuevos[] = $this->message;

        $id_compra = $this->quote->id;

        //dd($rol);
        if ($id_compra !== null) {

            $type = 'compra';
            $id_proceso_compra = $id_compra;
        }



        $user = auth()->user()->id;

        //dd($received);
        $comments = CommentsSupport::all()->where('id_proceso_compra', $this->quote->id);
        $lastcoment = CommentsSupport::latest()->first();

        switch ($user) {
            case Auth::user()->hasRole('buyer') == true:

                if ($comments->count() == 0) {

                    $comentario = CommentsSupport::create([
                        'user_id' => $user,
                        'id_proceso_compra' => $id_proceso_compra,
                        'type_proceso_compra' => $type,
                        'message' => $this->message,
                        'seller_id' => null,
                        'received_id' => null,
                        'emisor_id' => auth()->user()->id,

                    ]);
                } else {

                    $comentario = CommentsSupport::create([
                        'user_id' => $user,
                        'id_proceso_compra' => $id_proceso_compra,
                        'type_proceso_compra' => $type,
                        'message' => $this->message,
                        'seller_id' => $lastcoment->seller_id,
                        'received_id' => $lastcoment->user_id,
                        'emisor_id' => auth()->user()->id,

                    ]);
                }
                break;
            case Auth::user()->hasRole('seller') == true:
                $comentario = CommentsSupport::create([
                    'user_id' => $user,
                    'id_proceso_compra' => $id_proceso_compra,
                    'type_proceso_compra' => $type,
                    'message' => $this->message,
                    'seller_id' => auth()->user()->id,
                    'received_id' => $this->quote->user_id,
                    'emisor_id' => auth()->user()->id,

                ]);
                break;
            default:
                # code...
                break;
        }
        $this->message = '';
        event(new \App\Events\ChatEvent($comentario, $this->message));
    }

    public function Comments()
    {
        $comments = CommentsSupport::all('message');
        // dd($comments);
        return $comments;
    }

    public function recibio()
    {
        /*   $this->quote->user_id; */
        $lastcoment = CommentsSupport::latest()->first();
        $lastcoment->received_id;
    }

    public function updatePedidoStatus()
    {
        $quote = Quote::find($this->quote->id);
        if ($quote) {
            $quote->status = $this->quoteStatus; // Modificar el valor del atributo
            $quote->save(); // Guardar los cambios en la base de datos
            $user = $this->quote->user;

            $dataNotification = [
                'user' => auth()->user()->name,
                'pedido' => 'ODC-' . $quote->id,
                'status' => $this->quoteStatus,
                'pedido_id' => $quote->id,
            ];
            // Enviar notificacion a los usuarios con el rol de vendedor y gerente de compras
            $user->notify(new StatusPedidoNotification($dataNotification));
            $this->dispatchBrowserEvent('cambio-status', ['type' => 'success',  'message' => 'Estatus actualizado']);
        }
    }
}
