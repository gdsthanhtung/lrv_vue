<?php

namespace App\Http\Requests;

use App\Models\Department;
use App\Models\Enumeration;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    private $table = 'users';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];

        $enumStatus = Enumeration::where('refTable', '=', 'users')->get()->pluck('id')->toArray();
        $departments = Department::where('status_id', '=', '1')->get()->pluck('id')->toArray();
        //$roles = Role::where('status', '=', '1')->get()->pluck('id')->toArray();

        if (Request::isMethod('post')){
            return [
                'name'          => ['required','between:4,50'],
                'username'      => ['required','between:4,50',Rule::unique($this->table,'username')],
                'email'         => ['required','email',Rule::unique($this->table,'email')],
                'status_id'     => ['required',Rule::in($enumStatus)],
                'department_id' => ['required',Rule::in($departments)],
                'password'      => ['required','between:6,30','confirmed'],
                'password_confirmation' => ['required','between:6,30'],
                'avatar'        => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            ];
        }

        if (Request::isMethod('put')){
            return [
                'name'          => ['required','between:4,50'],
                'username'      => ['required','between:4,50',Rule::unique($this->table,'username')->ignore($this->id)],
                'email'         => ['required','email',Rule::unique($this->table,'email')->ignore($this->id)],
                'status_id'     => ['required',Rule::in($enumStatus)],
                'department_id' => ['required',Rule::in($departments)],
                'password'      => ($this->change_password) ? ['required','between:6,30','confirmed'] : [],
                'password_confirmation' => ($this->change_password) ? ['required','between:6,30'] : [],
                'avatar'        => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $required       = ':attribute không được để trống';
        $between        = ':attribute (:input) không hợp lệ, vui lòng nhập :min - :max ký tự';
        $betweenNoInput = ':attribute không hợp lệ, vui lòng nhập :min - :max ký tự';
        $invalid        = ':attribute (:input) không hợp lệ';
        $existed        = ':attribute (:input) đã tồn tại';
        $pwdCfm         = ':attribute và Xác nhận :attribute không đúng';

        return [
            'name.required' => $required,
            'name.between'  => $between,

            'username.required' => $required,
            'username.between'  => $between,
            'username.unique'   => $existed,

            'email.required'    => $required,
            'email.email'       => $invalid,
            'email.unique'      => $existed,

            'password.required'     => $required,
            'password.between'      => $betweenNoInput,
            'password.confirmed'    => $pwdCfm,

            'password_confirmation.required'    => $required,
            'password_confirmation.between'     => $betweenNoInput,

            'status_id.in'          => $invalid,
            'status_id.required'    => $required,

            'department_id.in'          => $invalid,
            'department_id.required'    => $required,

            'avatar.required'   => $required,
            'avatar.image'      => ':attribute phải là ảnh',
            'avatar.mimes'      => ':attribute phải có định dạng jpeg, png, jpg, gif, svg',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name'          => 'Tên đầy đủ',
            'username'      => 'Tài khoản',
            'email'         => 'Email',
            'password'      => 'Mật khẩu',
            'password_confirmation' => 'Xác nhận Mật khẩu',
            'status_id'             => 'Trạng thái',
            'department_id'         => 'Phòng ban',
            'avatar'                => 'Ảnh đại diện',
        ];
    }
}
