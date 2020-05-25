<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\KorisnikModel;

class RecenzentFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $korisnikModel=new KorisnikModel();
        $session=session();
        if($session->has('korisnik')){
            $status=$korisnikModel->dohvatiStatus($session->get('korisnik')->IdKor);
            if($status!='Recenzent')
                return redirect()->to(site_url($status));
        }
        else{
            return redirect()->to(site_url('/'));
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}