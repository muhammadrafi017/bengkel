<?php
namespace App\Http\Middleware;
use Closure;
use Symfony\Component\HttpFoundation\ParameterBag;
class TransformData
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        if ($request->isJson()) {
            $this->clean($request->json());
        } else {
            $this->clean($request->request);
        }
      
        return $next($request);
    }
    /**
    * Clean the request's data by removing mask from phonenumber.
    *
    * @param  \Symfony\Component\HttpFoundation\ParameterBag  $bag
    * @return void
    */
    private function clean(ParameterBag $bag)
    {
        $bag->replace($this->cleanData($bag->all()));
    }
    /**
    * Check the parameters and clean the number
    *
    * @param  array  $data
    * @return array
    */
    private function cleanData(array $data)
    {
        return collect($data)->map(function ($value, $key) {
            if ($key == 'debit' || $key == 'credit') {
                return preg_replace("/([^0-9])/", '', $value);
            } else {
                return $value;
            }
        })->all();
    }
}