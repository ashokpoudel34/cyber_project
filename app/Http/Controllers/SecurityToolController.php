<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class SecurityToolController extends Controller
{
    public function index(Request $request)
    {
        
        $request->validate(
            [
                "geolocationInput" => $request->has('geolocation') ? "required|ipv4" : "",
                "nmapInput" => $request->has('nmap') ? "required|ipv4" : "",
                "gobusterInput" => $request->has('gobuster') ? "required|url" : "",
                "gobustersubdomainInput" => $request->has('gobustersubdomain') ? "required|url" : "",
                "dirbInput" => $request->has('dirb') ? "required|url" : "",
                "domainInput" => $request->has('domain') ? [
                    'required',
                    'regex:/^(([a-zA-Z]|\d|[a-zA-Z]\d|[a-zA-Z]\d[a-zA-Z])*(-([a-zA-Z]|\d|[a-zA-Z]\d|[a-zA-Z]\d[a-zA-Z]))?(\.)?)+([a-zA-Z][a-zA-Z\d-]{0,61})?[a-zA-Z\d]\.[a-zA-Z]{2,6}(\.[a-zA-Z]{2,6})?$/'
                ] : ""
            ],
            [
                "geolocationInput.required" => "Please Enter IPv4 address.",
                "geolocationInput.ipv4" => "Please Enter valid IPv4 address for Geolocation.",
                "nmapInput.required" => "Please Enter IPv4 address.",
                "nmapInput.ipv4" => "Please Enter valid IPv4 address for Nmap.",
                "gobusterInput.required" => "Please Enter URL.",
                "gobusterInput.url" => "Please Enter valid URL for Gobuster.",
                "gobustersubdomainInput.required" => "Please Enter URL.",
                "gobustersubdomainInput.url" => "Please Enter valid URL for Gobuster Sub Domain.",
                "dirbInput.required" => "Please Enter URL.",
                "dirbInput.url" => "Please Enter valid URL for Dirb.",
                "domainInput.required" => "Please Enter domain name.",
                "domainInput.regex" => "Please Enter valid domain name for Lookup."
            ]
        );
        

        $geolocationInput = $request->input('geolocationInput');
        $domainInput = $request->input('domainInput');
        $nmapInput = $request->input('nmapInput');
        $gobusterInput = $request->input('gobusterInput');
        $gobustersubdomainInput = $request->input('gobustersubdomainInput');
        $dirbInput = $request->input('dirbInput');
        $results = [];



        if ($request->has('geolocation')) {
            $results['geolocation'] = shell_exec("whois $geolocationInput");
        }

        if ($request->has('domain')) {
            $results['domain'] = shell_exec("nslookup $domainInput");
        }

        if ($request->has('nmap')) {
            $results['nmap'] = shell_exec("sudo nmap -Pn -F  $nmapInput");
        }

        if ($request->has('gobuster')) {
            $results['gobuster'] = shell_exec("sudo gobuster dir -u $gobusterInput -w /usr/share/dirb/wordlists/common.txt");
        }

        if ($request->has('dirb')) {
            shell_exec("sudo dirb $dirbInput -o /var/www/cyber_project/public/output.txt");
            $results['dirb'] = shell_exec("cat /var/www/cyber_project/public/output.txt");
            shell_exec("sudo rm /var/www/cyber_project/public/output.txt");
        }

        if ($request->has('gobustersubdomain')) {
            $results['gobustersubdomain'] = shell_exec("sudo gobuster vhost -u $gobustersubdomainInput -w /usr/share/wordlists/discovery/top_subdomains.txt --append-domain -t 40");
        }
        return view('home', ['results' => $results]);
    }
}

