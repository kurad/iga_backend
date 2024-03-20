<?php

namespace App\Services;

use Exception;
use App\Models\Unit;
use App\DTO\Unit\CreateUnitDto;
use App\DTO\Unit\UpdateUnitDto;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\InvalidDataGivenException;
use App\Models\Subject;

class UnitService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function create(CreateUnitDto $data): Unit
    {

        $unit_title = $data->unit_title;
        $key_unit_competence = $data->key_unit_competence;
        $subject_id = $data->subject_id;

        $unitExists = Unit::where("unit_title", $subject_id)->exists();
        
        if ($unitExists) {
            throw new InvalidDataGivenException("The Unit already exists");
        }

        try {
            $unit = Unit::create([
                "unit_title" => $unit_title,
                "key_unit_competence" =>$key_unit_competence,
                "subject_id" => $subject_id,
                
            ]);

            return $unit;
        } catch (Exception $th) {
            Log::error("Failed to create school ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getUnit(int $id): ?Unit
    {
        $unit = Unit::find($id);
        if (is_null($unit)) {
            throw new ItemNotFoundException("Sorry, this unit cannot be found");
        }
        return $unit;
    }

    public function allUnit()
    {
        $units = Unit::join('subjects','subjects.id','=','units.subject_id')
                        ->select('units.unit_title','units.key_unit_competence', 'subjects.name')
                        ->get();
        return $units;
    }

    public function updateUnit(UpdateUnitDto $data, int $id): Unit
    {
        $unit = Unit::find($id);
        if (is_null($unit)) {
            throw new ItemNotFoundException("The unit does not exist");
        }

        $unit_title = $data->unit_title;
        $key_unit_competence = $data->key_unit_competence;
        $subject_id = $data->subject_id;

        try {
            $unit->update([
                "unit_title" => $unit_title,
                "key_unit_competence" =>$key_unit_competence,
                "subject_id" => $subject_id,
            ]);

            return $unit;
        } catch (Exception $th) {

            Log::error("Failed to update subject ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroy(int $id): bool
    {
        $unit = Unit::find($id);
        if (is_null($unit)) {
            throw new ItemNotFoundException("The unit does not exist");
        }
        return $unit->delete();
    }

    public function unitsPerSubject(int $subjectId)
    {

        $units = Unit::join('subjects','subjects.id','=','units.subject_id')
        ->where("units.subject_id", "=", $subjectId)
        ->get(['subjects.id','subjects.name','units.unit_title','units.key_unit_competence']);
        return$units;
        
    }

    public function SubjectName(int $subjectId)
    {
            // $subject = Unit::join('subjects','subjects.id','=','units.subject_id')
        // ->where("units.subject_id", "=", $subjectId)
        // ->select('subjects.id','subjects.name')
        // ->first();
        $subject = Subject::join('levels','levels.id','=','subjects.level_id')
        ->where('subjects.id','=',$subjectId)->first(['subjects.name','subjects.id','levels.name as levelName']);

        return $subject;
        
    }
}