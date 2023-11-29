<?php

namespace App\Http\Livewire;

use App\Events\MuestraStatusEvent;
use App\Models\Catalogo\GlobalAttribute;
use App\Models\CommentsSupport;
use App\Models\MessageSoporte;
use App\Models\Muestra;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MuestraStatusNotification;
use App\Models\Quote;
use App\Models\Role;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;


class ProcesoMuestraComponent extends Component
{
    use AuthorizesRequests;
    public $commentsmuestras;
    public $idMuestra, $muestra;
    public $id_compra, $id_muestra, $type, $comentario;
    public $quote;
    public $productStatus;

    public $muestras;
    protected $listeners = ['statusUpdated', 'echo:real-time,ChatEvent' => 'Comments',];

    public $messagesnuevos = [];
    public $message;
    public $users;
    public function goBack()
    {
        if (Auth::user()->hasRole('seller')) {
            return redirect()->route('seller.muestras');
        } elseif (Auth::user()->hasRole('buyer')) {
            return redirect()->route('muestras');
        } elseif (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
    }

    public function render()
    {
        $comments = CommentsSupport::join('users', 'users.id', 'comments_supports.user_id')
            ->join('role_user', 'role_user.user_id', 'users.id')
            ->where('id_proceso_compra', $this->idMuestra)
            ->where('type_proceso_compra', 'muestra')
            ->select(
                'comments_supports.created_at',
                'comments_supports.message',
                'users.name',
                'role_user.role_id'
            )
            ->get();
        $utilidad = (float) config('settings.utility');
        $db = config('database.connections.mysql_catalogo.database');
        $muestra = Muestra::find($this->idMuestra);
        $product = $muestra->product;
        $cost_send = 0;
        return view('livewire.proceso-muestra-component', compact('muestra', 'utilidad', 'product', 'cost_send', 'comments'));
    }

    public function mount()
    {
        $this->muestra = Muestra::find($this->idMuestra);
        $status =  $this->muestra->status;
        $this->productStatus = $status;
        $muestra = Muestra::find($this->idMuestra);
        $this->productStatus = $muestra->status;
    }

    public function updateMuestraStatus()
    {
        $product = Muestra::find($this->idMuestra);
        if ($product) {
            $product->status = $this->productStatus; // Modificar el valor del atributo
            $product->save(); // Guardar los cambios en la base de datos
        }
        self::muestra_notificacion($product);
        // Browser event
        $this->dispatchBrowserEvent('cambio-status', ['type' => 'success',  'message' => 'Estatus actualizado']);
    }

    static function muestra_notificacion($product)
    {
        event(new MuestraStatusEvent($product));
    }
    public function addMessage()
    {
        $this->validate([
            'message' => 'required',
        ]);
        $this->messagesnuevos[] = $this->message;
        $id_compra = $this->quote;
        $id_muestra = $this->idMuestra;

        if ($id_compra !== null) {

            $type = 'compra';
        } elseif ($id_muestra !== null) {
            $type = 'muestra';
        } else {
        }

        $comentario = CommentsSupport::create([
            'user_id' => auth()->user()->id,
            'id_proceso_compra' => $id_muestra,
            'type_proceso_compra' => $type,
            'message' => $this->message,
            'seller_id' => Auth::user()->hasRole('seller'),
            'emisor_id' => auth()->user()->id,
        ]);
        $this->message = '';
        event(new \App\Events\ChatEvent($comentario, $this->message));
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'comentario enviado']);
    }

    public function Comments()
    {
        $commentsmuestras = CommentsSupport::all('message');

        return $commentsmuestras;
    }
}
