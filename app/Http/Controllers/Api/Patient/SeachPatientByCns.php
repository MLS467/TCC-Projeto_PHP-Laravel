<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\PatientCNS;
use Illuminate\Http\Request;

class SeachPatientByCns extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->input('cns')) {
            return response()->json(['erro' => 'CNS não informado'], 400);
        }

        $cns = $request->input('cns');

        $p = PatientCNS::where('cns', $cns)->first();

        if (!$p) {
            return response()->json(['erro' => 'Paciente não encontrado'], 404);
        }

        return [
            "resourceType" => "Patient",
            "id" => $p->id,
            "identifier" => [
                [
                    "system" => "http://saude.gov.br/cns",
                    "value" => $p->cns
                ],
                [
                    "system" => "http://saude.gov.br/cpf",
                    "value" => $p->cpf
                ]
            ],
            "name" => [
                [
                    "use"   => "official",
                    "text"  => $p->nome,
                    "family" => explode(' ', $p->nome)[1] ?? "",
                    "given" => [explode(' ', $p->nome)[0]]
                ]
            ],
            "gender" => $p->genero,
            "birthDate" => $p->data_nascimento,
            "address" => [
                [
                    "line" => [$p->endereco],
                    "city" => $p->cidade,
                    "state" => $p->estado,
                    "postalCode" => $p->cep
                ]
            ],
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $p->telefone,
                    "use" => "mobile"
                ]
            ]
        ];
    }
}