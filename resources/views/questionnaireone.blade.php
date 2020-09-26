@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <form method="POST" class="form" action="{{ route('questionnaireOneSubmit') }}">
                @csrf
                <h1 class="title text-center">Cuestionario habilitante</h1>
                <h3>¿Tiene Usted y/o algún familiar que viva en su misma residencia (personas con las que entro en contacto directo)?</h3>
                <div class="ml-4">
                    <input type="checkbox" name="condition_1" value="Hipertensión arterial"> Hipertensión arterial<br>
                    <input type="checkbox" name="condition_2" value="Afecciones pulmonares"> Afecciones pulmonares<br>
                    <input type="checkbox" name="condition_3" value="Insuficiencia renal"> Insuficiencia renal<br>
                    <input type="checkbox" name="condition_4" value="Lupus"> Lupus<br>
                    <input type="checkbox" name="condition_5" value="Cáncer"> Cáncer<br>
                    <input type="checkbox" name="condition_6" value="Diabetes mellitus"> Diabetes mellitus<br>
                    <input type="checkbox" name="condition_7" value="Obesidad"> Obesidad<br>
                    <input type="checkbox" name="condition_8" value="Insuficiencia hepática o metabólica"> Insuficiencia hepática o metabólica<br>
                    <input type="checkbox" name="condition_9" value="Asma"> Asma<br>
                    <input type="checkbox" name="condition_10" value="Fibromialgia"> Fibromialgia<br>
                    <input type="checkbox" name="condition_11" value="Trombosis venosa profunda"> Trombosis venosa profunda<br>
                    <input type="checkbox" name="condition_11" value="Antecedentes de infarto al miocardio"> Antecedentes de infarto al miocardio<br>
                    <input type="checkbox" name="condition_11" value="Antecedentes de eventos cerebro vasculares"> Antecedentes de eventos cerebro vasculares<br>
                    <input type="checkbox" name="condition_11" value="Enfermedad cardíaca"> Enfermedad cardíaca<br>
                    <input type="checkbox" name="condition_11" value="Mujer embarazada"> Mujer embarazada<br>
                    <input type="checkbox" name="condition_11" value="Mujer en período de lactancia"> Mujer en período de lactancia<br>
                </div>
                <h3 class="mt-5">Marque si usted convive con uno a varios de los siguientes funcionarios o trabajadores</h3>
                <div class="ml-4">
                    <input type="checkbox" name="contact_1" value="Personal de Salud que atienden de manera directa a pacientes con COVID-19"> Personal de Salud que atienden de manera directa a pacientes con COVID-19<br>
                    <input type="checkbox" name="contact_2" value="Otras profesiones en riesgo por contacto directo con COVID-19"> Otras profesiones en riesgo por contacto directo con COVID-19<br>
                </div>
                <div class="row mt-4">
                     <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
