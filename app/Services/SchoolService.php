<?php

namespace App\Services;

use Exception;
use App\Models\School;
use App\DTO\School\CreateSchoolDto;
use App\DTO\School\UpdateSchoolDto;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\InvalidDataGivenException;

class SchoolService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function create(CreateSchoolDto $data): School
    {

        $name = $data->name;
        $type = $data->type;
        $sector_id = $data->sector_id;


        $schoolExists = School::where("name", $name)->exists();
        if ($schoolExists) {
            throw new InvalidDataGivenException("The school name already exists");
        }

        try {
            $school = School::create([
                "name" => $name,
                "type" => $type,
                "sector_id" => $sector_id,
                
            ]);

            return $school;
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

    public function getSchool(int $id): ?School
    {
        $school = School::find($id);
        if (is_null($school)) {
            throw new ItemNotFoundException("Sorry, this school cannot be found");
        }
        return $school;
    }

    public function allSchools(): Collection
    {
        $schools = School::all();

        return $schools;
    }

    public function updateSchool(UpdateSchoolDto $data, int $id): School
    {
        $school = School::find($id);
        if (is_null($school)) {
            throw new ItemNotFoundException("The school does not exist");
        }

        $name = $data->name;
        $type = $data->type;
        $sector_id = $data->sector_id;

        try {
            $school->update([
                "name" => $name,
                "type" => $type,
                "sector_id" => $sector_id,
            ]);

            return $school;
        } catch (Exception $th) {

            Log::error("Failed to update school ", [
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
        $school = School::find($id);
        if (is_null($school)) {
            throw new ItemNotFoundException("The school does not exist");
        }
        return $school->delete();
    }
    public function schoolDetails()
    {
        $schoolInfo = School::join('sectors','sectors.id','=','schools.sector_id')
                            ->join('districts', 'districts.id','=','sectors.district_id')
                            ->join('provinces', 'provinces.id', '=', 'districts.province_id')
                            ->get();

        return($schoolInfo);
    }
}