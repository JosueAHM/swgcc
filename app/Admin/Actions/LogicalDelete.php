<?php

namespace App\Admin\Actions;

use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class LogicalDelete extends RowAction
{
    public $name = 'Eliminacion Logica';

    public $icon = 'icon-trash';

    public function dialog()
    {
        $this->question('¿Estás seguro de eliminar este registro?', 'No podrás cambiar el estado del registro', ['icon'=>'question','confirmButtonText'=>'Sí']);

    }

    public function handle(Model $model)
    {
        $model->status = 0;
        $model->save();

        return $this->response()->success('Se ha eliminado el registro exitosamente')->refresh();
    }
}