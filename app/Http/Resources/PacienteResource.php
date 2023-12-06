<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    //Esto es una capa para transformar los datos del modelo y la capa JSON, en pocas palabras editar como quiero que se muestren los datos en el JSON

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombres' => Str::of($this->nombres)->upper(),//Convertimos a mayusculas
            'apellidos' => Str::of($this->apellidos)->upper(),//Convertimos a mayusculas
            'edad' => $this->edad,
            'sexo' => $this->sexo,
            'dni' => $this->dni,
            'tipo_sangre' => $this->tipo_sangre,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'direccion' => $this->direccion,
            'fecha_creado' => $this->created_at->format('d-m-Y'),
            'fecha_modificado' => $this->updated_at->format('d-m-Y')
        ];
    }

    //Junto con la data que retorno arriba quiero retornar esto de abajo tambien 

    public function with($request)
    {
        return [
            'res' => true,
        ];
    }
}
