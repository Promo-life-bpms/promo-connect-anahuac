<?php

namespace App\Http\Livewire;

use App\Models\Material;
use App\Models\MaterialTechnique;
use App\Models\PricesTechnique;
use App\Models\Size;
use App\Models\SizeMaterialTechnique;
use App\Models\Technique;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportTechniques extends Component
{
    use WithFileUploads;

    // Datos iniciales
    public $fileLayout, $tipo, $updateProducts = false;

    // Dastos despues del paso 1
    public $rutaArchivo;
    public $archivo;

    public function render()
    {
        return view('livewire.import-techniques.import-techniques');
    }

    public function save()
    {
        $this->validate([
            'fileLayout' => 'required', // 1MB Max
        ]);
        // Mostrar columnas
        $path = time() . $this->fileLayout->getClientOriginalName();
        $this->fileLayout->storeAs('public/imports', $path);
        $this->rutaArchivo = public_path('storage/imports/' . $path);
        $this->archivo = $path;

        $documento = IOFactory::load($this->rutaArchivo);
        $hojaActual = $documento->getSheet(0);
        $letraMayorDeColumna = $hojaActual->getHighestColumn(); // Numérico
        $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
        $numeroMayorDeFila = $hojaActual->getHighestRow();
        $columns = [];
        for ($indiceCol = 1; $indiceCol <= $numeroMayorDeColumna; $indiceCol++) {
            array_push($columns, $hojaActual->getCellByColumnAndRow($indiceCol, 1)->getValue());
        }
        if ($numeroMayorDeColumna < 8) {
            session()->flash('error', "Al parecer no estan todas las columnas");
            return;
        }
        $information = [];
        $errores = [];
        for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
            $data = [
                "material" => $hojaActual->getCellByColumnAndRow(1, $indiceFila)->getValue(),
                "extras" => $hojaActual->getCellByColumnAndRow(2, $indiceFila)->getValue(),
                "technique" => $hojaActual->getCellByColumnAndRow(5, $indiceFila)->getValue(),
                "size" => $hojaActual->getCellByColumnAndRow(6, $indiceFila)->getValue(),
                "start" => $hojaActual->getCellByColumnAndRow(3, $indiceFila)->getValue(),
                "end" => $hojaActual->getCellByColumnAndRow(4, $indiceFila)->getValue(),
                "price" => $hojaActual->getCellByColumnAndRow(7, $indiceFila)->getValue(),
                "type" => $hojaActual->getCellByColumnAndRow(8, $indiceFila)->getValue()
            ];
            foreach ($data as $key => $value) {
                if (trim($value) == "" || $value == null) {
                    array_push($errores, [$indiceFila, $key, $value]);
                }
            }
            array_push($information, $data);
        }
        if (count($errores) > 0) {
            $message = '';
            foreach ($errores as $value) {
                $message = $message . 'En la fila ' . $value[0] . ', columna: ' . $value[1] . ' tienes un valor incorrecto o vacio<br>';
            }
            session()->flash('error', $message);
            return;
        }
        // Eliminar los datos anteriores
        try {
            DB::table('prices_techniques')->delete();
            DB::table('size_material_technique')->delete();
            DB::table('material_technique')->delete();
            DB::table('materials')->delete();
            DB::table('sizes')->delete();
            DB::table('techniques')->delete();
        } catch (Exception $th) {
            session()->flash('error', $th->getMessage());
        }

        // Comenzar a cargar las tecnicas
        foreach ($information as $dataInfo) {
            try {
                // Comenzar registrando la tecnica y el materia
                $slugMaterial = mb_strtolower(str_replace(' ', '-', $dataInfo['material']));
                $material = Material::where("slug", $slugMaterial)->first();
                if (!$material) {
                    $material = Material::create([
                        'nombre' => $dataInfo['material'],
                        'extras' => $dataInfo['extras'],
                        'slug' => $slugMaterial,
                    ]);
                }

                $slugTecnique = mb_strtolower(str_replace(' ', '-', $dataInfo['technique']));
                $technique = Technique::where("slug", $slugTecnique)->first();
                if (!$technique) {
                    $technique = Technique::create([
                        'nombre' => $dataInfo['technique'],
                        'slug' => $slugTecnique,
                    ]);
                }

                $materialTechnique = MaterialTechnique::where('technique_id', $technique->id)->where('material_id', $material->id)->first();
                if (!$materialTechnique) {
                    $materialTechnique = MaterialTechnique::create([
                        'technique_id' => $technique->id,
                        'material_id' => $material->id
                    ]);
                }

                $slugSize = mb_strtolower(str_replace(' ', '-', $dataInfo['size']));
                $size = Size::where("slug", $slugSize)->first();
                if (!$size) {
                    $size = Size::create([
                        'nombre' => $dataInfo['size'],
                        'slug' => $slugSize,
                    ]);
                }

                $sizeMaterialTechnique = SizeMaterialTechnique::where('size_id', $size->id)->where('material_technique_id', $materialTechnique->id)->first();
                if (!$sizeMaterialTechnique) {
                    $sizeMaterialTechnique = SizeMaterialTechnique::create([
                        'size_id' => $size->id,
                        'material_technique_id' => $materialTechnique->id
                    ]);
                }


                $priceTechnique = PricesTechnique::create([
                    'size_material_technique_id' => $sizeMaterialTechnique->id,
                    'escala_inicial' => floatval($dataInfo['start']),
                    'escala_final' => $dataInfo['end'] == '-' ? null : floatval($dataInfo['end']),
                    'precio' => floatval($dataInfo['price']),
                    'tipo_precio' => $dataInfo['type']
                ]);
            } catch (Exception $th) {
                session()->flash('error', "Error al insertar la informacion, revise el archivo e intentelo de muevo");
            }
        }
        session()->flash('message', "Actualizacion realizada correctamente");

        $this->columns = $columns;
    }
}
