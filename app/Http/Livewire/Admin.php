<?php

namespace App\Http\Livewire;

use App\Mail\ConfirmationMail;
use App\Mail\RejectMail;
use Livewire\Component;
use illuminate\Pagination\paginator;
use Livewire\WithPagination;
use App\Models\Patient;
use Illuminate\Support\Facades\Mail;

class Admin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $term = null, $file_id;

    public function render()
    {
        $searchTerm = '%'.$this->term.'%';
        $collection = Patient::where('name', 'LIKE', $searchTerm)->orWhere('email', 'LIKE', $searchTerm)->paginate(7);
        $inactiveCollection = Patient::where('status' , 'Inactive')->get();
        $counter = Patient::where('status' , 'Inactive')->count();
        return view('livewire.admin', [
            'collection'=>$collection,
            'pagination'=>$collection->toArray(),
            'counter'=>$counter,
            'inactiveCollection'=>$inactiveCollection
        ]);
    }
    public function accept() {
        $patient = Patient::find($this->file_id);
        if ($patient) {
            if ($patient->status === 'Active') {
                $patient->status = 'Inactive';
                Mail::to($patient->email)->send(new RejectMail($patient));
            } elseif ($patient->status === 'Inactive') {
                $patient->status = 'Active';
                Mail::to($patient->email)->send(new ConfirmationMail($patient));
            }
            $this->dispatchBrowserEvent('deleteModalHide');
            $patient->save();
        }
        $this->render();
    }
    public function delete($id){
        $patient = Patient::find($id);
        if(!is_null($id)){
            $patient->delete();
            Mail::to($patient->email)->send(new RejectMail($patient));
        }
        $this->render();
    }
    public function deleteModalShow($id)
    {
        $this->file_id = $id;
        $this->dispatchBrowserEvent('deleteModalShow');
    }
    public function deleteModalHide()
    {
        $this->dispatchBrowserEvent('deleteModalHide');
    }
}
