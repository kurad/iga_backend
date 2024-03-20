<?php

namespace App\Services;

use Exception;
use App\Models\Level;
use App\Models\School;
use Illuminate\Http\Request;
use App\DTO\Level\CreateLevelDto;
use App\DTO\Level\UpdateLevelDto;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\InvalidDataGivenException;


class LevelService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function create(CreateLevelDto $data): Level
    {

        $name = $data->name;


        $levelExists = Level::where("name", $name)->exists();
        if ($levelExists) {
            throw new InvalidDataGivenException("The level name already exists");
        }

        try {
            $level = Level::create([
                "name" => $name
            ]);

            return $level;
        } catch (Exception $th) {
            Log::error("Failed to create level ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getLevel(int $id): ?Level
    {
        $level = Level::find($id);
        if (is_null($level)) {
            throw new ItemNotFoundException("Sorry, this level cannot be found");
        }
        return $level;
    }

    public function allLevels(): Collection
    {
        $levels = Level::orderBy('name')->get();

        return $levels;
    }

    public function update(UpdateLevelDto $data, int $id): Level
    {
        $level = Level::find($id);
        if (is_null($level)) {
            throw new ItemNotFoundException("The level does not exist");
        }

        $name = $data->name;
        try {
            $level->update([
                "name" => $name,
            ]);

            return $level;
        } catch (Exception $th) {

            Log::error("Failed to update level ", [
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

    public function provinces()
    {
        $provinces = DB::table('provinces')->get();
        return ($provinces);
    }
    public function districts(Request $request)
    {
        $districts = DB::table('districts')->where('province_id',$request->province_id)->get();
        return ($districts);
    }

    public function sectors(Request $request)
    {
        $sectors = DB::table('sectors')->where('district_id',$request->district_id)->get();
        return ($sectors);
    }

    public function cells(Request $request)
    {
        $cells = DB::table('cells')->where('sector_id',$request->sector_id)->get();
        return ($cells);
    }
    public function schools(Request $request)
    {
        $schools = DB::table('schools')->where('sector_id', $request->sector_id)->get();
        return ($schools);
    }
}