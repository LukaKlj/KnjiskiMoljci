<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\KorisnikModel;

class GostFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $korisnikModel=new KorisnikModel();
        $session=session();
        if($session->has('korisnik')){
            $status=$korisnikModel->dohvatiStatus($session->get('korisnik')->IdKor);
            return redirect()->to(site_url($status));
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}