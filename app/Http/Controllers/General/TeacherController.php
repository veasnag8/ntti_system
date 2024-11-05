<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\General\Skills;
use App\Models\General\Teachers;
use App\Models\SystemSetup\Department;
use App\Models\User;
use App\Service\service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public $services;
    public $page_id;
    public $page;
    public $prefix;
    public $table_id;
    public $arrayJoin = [];
    function __construct()
    {
        $this->services = new service();
        $this->page_id = "10001";
        $this->page = "teachers";
        $this->prefix = "teachers";
        $this->arrayJoin = ['10001', '10007', '10008'];
        $this->table_id = "10005";
    }
    public function index(){
        $page = $this->page;
        $records = Teachers::orderBy('code', 'asc')->paginate(10);
        $department = Department::get();
        $skills = Skills::where('status', 'yes')->get();
        if(!Auth::check()){
            return redirect("login")->withSuccess('Opps! You do not have access');
        }  
        return view('general.teachers', compact('records','page', 'department', 'skills'));	
    }
    public function detail(){
        $page = $this->page;
        $records = Teachers::orderBy('code', 'asc')->paginate(10);
        $department = Department::get();
        $skills = Skills::where('status', 'yes')->get();
        if(!Auth::check()){
            return redirect("login")->withSuccess('Opps! You do not have access');
        }  
        return view('general.teachers', compact('records','page', 'department', 'skills'));	
    }
    public function transaction(request $request)
    {
        $data = $request->all();
        $type = $data['type'];
        $page = $this->page;
        $page_url = $this->page;
        $records = null;
        $department = Department::get();
        // $school_years = DB::table('school_years')->get();   
        $skills = DB::table('skills')->get();
        try {
            $params = ['records', 'type', 'page', 'skills', 'department'];
            if ($type == 'cr') return view('general.teachers_card', compact($params));
            if (isset($_GET['code'])) {
                $records = Teachers::where('code', $this->services->Decr_string($_GET['code']))->first();
            }
            return view('general.teachers_card', compact($params));
        } catch (\Exception $ex) {
            $this->services->telegram($ex->getMessage(), $this->page, $ex->getLine());
            return response()->json(['status' => 'warning', 'msg' => $ex->getMessage()]);
        }
    }
    public function delete(Request $request)
    {
        $code = $request->code;
        try {
            $records = Teachers::where('code',$code);
            $records->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'ទិន្ន័យត្រូវបាន លុប​!']);
        } catch (\Exception $ex) {
            $this->services->telegram($ex->getMessage(), $this->page, $ex->getLine());
            return response()->json(['status' => 'warning', 'msg' => $ex->getMessage()]);
        }
    }
    public function update(Request $request)
    {
        $input = $request->all();
        $record = Teachers::where('code', $input['code'])->first();
        if (!$record) return response()->json(['status' => 'error', 'msg' => "មិនអាចកែប្រ លេខកូដ!"]);
        $code = $input['type'];
        try {
            $records = Teachers::where('code', $code)->first();
            if ($records) {
                $records->code = $request->code;
                $records->name_2 = $request->name_2;
                $records->name = $request->name;
                $records->date_of_birth = $request->date_of_birth;
                $records->gender = $request->gender;
                $records->address = $request->address;
                $records->email = $request->email;
                $records->phone_no = $request->phone_no;
                $records->id_card = $request->id_card;
                $records->department_code = $request->department_code;
                $records->father_name = $request->father_name;
                $records->mother_name = $request->mother_name;
                $records->date_of_joining = $request->date_of_joining;
                $records->marital_status = $request->marital_status;
                $records->qualification = $request->qualification;
                $records->status = $request->status;
                $records->work_exp = $request->work_exp;
                $records->update();
            }
            return response()->json(['status' => 'success', 'msg' => 'បច្ចុប្បន្នភាព ទិន្នន័យជោគជ័យ!', '$records' => $records]);
        } catch (\Exception $ex) {
            $this->services->telegram($ex->getMessage(), $this->page, $ex->getLine());
            return response()->json(['status' => 'warning', 'msg' => $ex->getMessage()]);
        }
    }
    public function store(request $request)
    {
        $input = $request->all();
        if (!$input['code']) {
            return response()->json(['status' => 'error', 'msg' => 'Field request form server!']);
        }
        $record = Teachers::where('code', $request->code)->first();
        if ($record) return response()->json(['status' => 'error', 'msg' => "$request->code.កូដមានរូចហើយ​ !"]);
        try {
            $records = new Teachers();
            $records->code = $request->code;
                $records->name_2 = $request->name_2;
                $records->name = $request->name;
                $records->date_of_birth = $request->date_of_birth;
                $records->gender = $request->gender;
                $records->address = $request->address;
                $records->email = $request->email;
                $records->phone_no = $request->phone_no;
                $records->id_card = $request->id_card;
                $records->department_code = $request->department_code;
                $records->father_name = $request->father_name;
                $records->mother_name = $request->mother_name;
                $records->date_of_joining = $request->date_of_joining;
                $records->marital_status = $request->marital_status;
                $records->qualification = $request->qualification;
                $records->status = $request->status;
                $records->work_exp = $request->work_exp;
                $records->save();
            return response()->json(['store' => 'yes', 'msg' => 'ទិន្នន័យ បន្ថែមជោគជ័យ!']);
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->services->telegram($ex->getMessage(), $this->page, $ex->getLine());
            return response()->json(['status' => 'warning', 'msg' => $ex->getMessage()]);
        }
    }
    public function Print(Request $request)
    {
        $data = $request->all();
        return dd($data);
        $class_record = null;
        $extract_query = $this->services->extractQuery($data);
        try {

            $records = Department::whereRaw($extract_query)->get();
            return view('student.student_print', compact('records', 'class_record'));
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->services->telegram($ex->getMessage(), $this->page, $ex->getLine());
            return response()->json(['status' => 'warning', 'msg' => $ex->getMessage()]);
        }
    }

    public function Search (Request $request,$page)
    {
        dd("helo");
        $input = $request->all();
        $strings = explode(" ", strtoupper($input['string']));
        $search_value = '';
        $user = Auth::user();
        if (count($strings) > 0) {
            if ($strings[0] == 'NEW' || $strings[0] == 'OPEN') {
                if (count($strings) > 2) {
                    for ($i = 1; $i < count($strings) - 1; $i++) {
                        $search_value .= $strings[$i] . " ";
                    }
                } else {
                    if (count($strings) == 2) {
                        $search_value = $strings[1];
                    }
                }
                $search_value = rtrim($search_value, " ");
                // check page
                if($page == 'student'){
                    $menus = DB::table('student')->where('name','like', $search_value . "%")
                                        ->orWhere('code', 'like', $search_value . "%")
                                        ->orWhere('name_2', 'like', $search_value . "%")
                                        ->where('class_code', '<>', null)->get();
                    $blade_file_record = 'student.student_list';
                }else if($page == 'department'){
                    $menus = DB::table('department')->where('department_name','like', $search_value . "%")
                                        ->where('id', '<>', null)->get();
                    $blade_file_record = 'department.department_list';
                }

                if (count($menus) > 0) {
                    foreach ($menus as $menu) {
                        if ($strings[0] == 'OPEN' && count($strings) > 2) {
                            $menu->code = $menu->code . ' ' . $strings[count($strings) - 1];
                        }
                        $menu->url = $menu->url . ($strings[0] == 'NEW' ? "type=cr" : "type=ed&code=" . $this->service->Encr_string($strings[count($strings) - 1]));
                    }
                }
            }else{
                for ($i = 0; $i < count($strings); $i++) {
                    $search_value .= $strings[$i] . " ";
                }
                $search_value = rtrim($search_value, " ");
                if($page == 'student'){
                    $menus = DB::table('student')->where('name', 'like', $search_value . "%")
                        ->orWhere('code', 'like', $search_value . "%")
                        ->orWhere('name_2', 'like', $search_value . "%")
                        ->where('class_code', '<>', null)->paginate(1000);
                    $blade_file_record = 'student.student_list';
                }else if($page == 'department'){
                    $menus = DB::table('department')->where('department_name','like', $search_value . "%")
                            ->where('id', '<>', null)->paginate(1000);
                    $blade_file_record = 'department.department_list';
                }
            }
           
            if (count($menus) > 0) {
                $records = $menus;
            }else{
                if($page == 'student'){
                    $records = Student::where('department_code',$user->childs)->paginate(10);
                }else if($page == 'department'){
                    $records = Department::paginate(15);
                }
            }
            $view = view($blade_file_record,compact('records'))->render();
            return response()->json(['status' =>'success','view' =>$view]);
        }
        return 'none';
    }
    public function CreateUser(Request $request)
    {
        $data = $request->all();
        try {
            $record = Teachers::where('code', $data['code'])->first();
            $name = $record->name;
            $check_record = User::where('user_code', $data['code'])->first();
            if ($check_record){
                return response()->json(['status' => 'error', 'msg' => 'User មានរូចហើយ​!']);
            }
            $records = new User();
            $records->email = $request->email;
            $records->name = $name;
            $records->password = Hash::make($data['password']);
            $records->role = 'teachers';
            $records->user_code = $data['code'];
            $records->save();
            return response()->json(['status' => 'success', 'msg' => 'User Student Create success!']);
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->services->telegram($ex->getMessage(), $this->page, $ex->getLine());
            return response()->json(['status' => 'warning', 'msg' => $ex->getMessage()]);
        }
    }
    public function details(){
        $page = $this->page;
        $records = Teachers::orderBy('code', 'asc')->paginate(10);
        $department = Department::get();
        $skills = Skills::where('status', 'yes')->get();
        if(!Auth::check()){
            return redirect("login")->withSuccess('Opps! You do not have access');
        }  
        return view('general.teachers_detail', compact('records','page', 'department', 'skills'));	
    }
    public function teachersDetailTransaction(request $request)
    {
        $data = $request->all();
        //dd($data,$this->services->Decr_string($_GET['code']));
        $type = $data['type'];
        $page = $this->page;
        $page_url = $this->page;
        $records = null;
        $department = Department::get();
        // $school_years = DB::table('school_years')->get();   
        $skills = DB::table('skills')->get();
        try {
            $params = ['records', 'type', 'page', 'skills', 'department'];
            if ($type == 'cr') return view('general.teachers_detail_card', compact($params));
            if (isset($_GET['code'])) {
                $records = Teachers::where('code', $this->services->Decr_string($_GET['code']))->first();
            }
            return view('general.teachers_detail_card', compact($params));
        } catch (\Exception $ex) {
            $this->services->telegram($ex->getMessage(), $this->page, $ex->getLine());
            return response()->json(['status' => 'warning', 'msg' => $ex->getMessage()]);
        }
    }
    

}
