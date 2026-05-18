<?php
namespace App\Controllers;

use App\Models\UserModel;

class Akun extends BaseController
{
    public function gantiPassword()
    {
        return view('akun/ganti_password', ['title' => 'Ganti Password']);
    }

    public function prosesGantiPassword()
    {
        $rules = [
            'password_lama' => 'required',
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]',
            ],
            'konfirmasi' => [
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'required|matches[password_baru]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        if (!password_verify($passwordLama, $user['password'])) {
            session()->setFlashdata('error', 'Password lama tidak cocok dengan database.');
            return redirect()->back()->withInput();
        }

        // Update password
        $userModel->update($userId, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT)
        ]);

        session()->setFlashdata('sukses', 'Password berhasil diubah.');
        return redirect()->to('/');
    }
}
