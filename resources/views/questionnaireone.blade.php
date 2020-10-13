@extends('layouts.app')

@section('main-content')
    <div  class="row">
        <div class="col-md-12">
            <form method="POST" class="form" action="{{ route('questionnaireOneSubmit') }}">
                @csrf
                <h1 class="title text-center">Cuestionario habilitante</h1>
                <h3>¿Tiene Usted y/o algún familiar que viva en su misma residencia (personas con las que entro en contacto directo)?</h3>
                <div class="ml-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_1" name="condition_1" value="Hipertensión arterial">
                        <label class="custom-control-label" for="condition_1"> Hipertensión arterial</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_2" name="condition_2" value="Afecciones pulmonares">
                        <label class="custom-control-label" for="condition_2"> Afecciones pulmonares</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_3" name="condition_3" value="Insuficiencia renal">
                        <label class="custom-control-label" for="condition_3"> Insuficiencia renal</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_4" name="condition_4" value="Lupus">
                        <label class="custom-control-label" for="condition_4"> Lupus</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_5" name="condition_5" value="Cáncer">
                        <label class="custom-control-label" for="condition_5"> Cáncer</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_6" name="condition_6" value="Diabetes mellitus">
                        <label class="custom-control-label" for="condition_6"> Diabetes mellitus</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_7" name="condition_7" value="Obesidad">
                        <label class="custom-control-label" for="condition_7"> Obesidad</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_8" name="condition_8" value="Insuficiencia hepática o metabólica">
                        <label class="custom-control-label" for="condition_8"> Insuficiencia hepática o metabólica</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_9" name="condition_9" value="Asma">
                        <label class="custom-control-label" for="condition_9"> Asma</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_10" name="condition_10" value="Fibromialgia">
                        <label class="custom-control-label" for="condition_10"> Fibromialgia</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_11" name="condition_11" value="Trombosis venosa profunda">
                        <label class="custom-control-label" for="condition_11"> Trombosis venosa profunda</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_12" name="condition_12" value="Antecedentes de infarto al miocardio">
                        <label class="custom-control-label" for="condition_12"> Antecedentes de infarto al miocardio</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_13" name="condition_13" value="Antecedentes de eventos cerebro vasculares">
                        <label class="custom-control-label" for="condition_13"> Antecedentes de eventos cerebro vasculares</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_14" name="condition_14" value="Enfermedad cardíaca">
                        <label class="custom-control-label" for="condition_14"> Enfermedad cardíaca</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_15" name="condition_15" value="Mujer embarazada">
                        <label class="custom-control-label" for="condition_15"> Mujer embarazada</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="condition_16" name="condition_16" value="Mujer en período de lactancia">
                        <label class="custom-control-label" for="condition_16"> Mujer en período de lactancia</label>
                    </div>
                </div>
                <h3 class="mt-5">Marque si usted convive con uno a varios de los siguientes funcionarios o trabajadores</h3>
                <div class="ml-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="circumstance_1" name="circumstance_1" value="Convive con: Personal de Salud que atienden de manera directa a pacientes con COVID-19">
                        <label class="custom-control-label" for="circumstance_1"> Personal de Salud que atienden de manera directa a pacientes con COVID-19</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="circumstance_2" name="circumstance_2" value="Trabaja con: Otras profesiones en riesgo por contacto directo con COVID-19">
                        <label class="custom-control-label" for="circumstance_2"> Otras profesiones en riesgo por contacto directo con COVID-19</label>
                    </div>
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
