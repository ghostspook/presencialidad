@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            @error('acceptance')
            <div class="alert alert-danger" role="alert">
                <h3 class="alert-heading">Descargo de responsabilidad</h3>
                Se le recomienda seguir la recomendación de no asistir presencialmente.
                Si a pesar de eso Usted prefiere continuar con el proceo de retorno, deberá hacer clic en el cuadro de abajo.
            </div>
            <div class="alert alert-info" role="alert">
                <h3 class="alert-heading">Importante</h3>
                El proceso de retorno a la presencialidad es completamente opcional y voluntario.
                No está Usted obligado a asistir presencialmente.
            </div>
            @enderror

        @if(!$userCard->poses_risk_due_work_home_circumstance)
            <h1 class="title text-center text-danger">Por su salud se le recomienda no asistir</h1>
        @else
            <h1 class="title text-center text-danger">Por su salud y la de los demás se le recomienda no asistir</h1>
        @endif
            <form method="POST" action="{{ route('submitDontFollowAdvice') }}">
                @csrf

                <div class="custom-control custom-checkbox mt-5">
                    @if(!$userCard->poses_risk_due_work_home_circumstance)
                        <input type="checkbox" class="custom-control-input" id="acceptance" name="acceptance" value="Tengo claro que no estoy obligado a asistir, pero asumo el riesgo y decido continuar con el proceso de retorno a la presencialidad.">
                    @else
                        <input type="checkbox" class="custom-control-input" id="acceptance" name="acceptance" value="Tengo claro que no estoy obligado a asistir, pero asumo el riesgo y decido continuar con el proceso de retorno a la presencialidad. Además, me comprometo a realizarme (bajo mi propio costo) una prueba PCR cada mes.">
                    @endif
                @if(!$userCard->poses_risk_due_work_home_circumstance)
                @else
                @endif
                    <label class="custom-control-label" for="acceptance">
                        @if(!$userCard->poses_risk_due_work_home_circumstance)
                            Tengo claro que no estoy obligado a asistir,
                            pero asumo el riesgo y decido continuar con el proceso de retorno a la presencialidad.
                        @else
                            Tengo claro que no estoy obligado a asistir,
                            pero asumo el riesgo y decido continuar con el proceso de retorno a la presencialidad.
                            <strong class="text-danger">Además, me comprometo a realizarme (bajo mi propio costo) una prueba PCR cada mes.</strong>
                        @endif
                    </label>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-danger">Desestimar recomendación</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
