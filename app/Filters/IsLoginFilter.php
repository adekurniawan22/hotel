<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsLoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->has('role')) {
            if (session()->get('role') === 'admin') {
                session()->setFlashdata('success', 'Anda sudah login');
                return redirect()->to('/dashboard');
            }

            if (session()->get('role') === 'resepsionis') {
                session()->setFlashdata('success', 'Anda sudah login');
                return redirect()->to('/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah request
    }
}
