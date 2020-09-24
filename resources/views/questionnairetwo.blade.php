@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <form method="POST" class="form" action="{{ route('questionnaireTwoSubmit') }}">
                @csrf

                <h3>¿Usted ha presentado síntomas de COVID (fiebre, dolor de cabeza, dolor de garganta, tos, dolor en el pecho, pérdida del olfato o el gusto, vómito, mareo) desde el último test negativo que se ha realizado?</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question1" id="r1" value="Presenta síntomas COVID-19" checked>
                        <label class="form-check-label" for="r1">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question1" id="r2" value="no">
                        <label class="form-check-label" for="r2">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Usted ha frecuentado bares, restaurantes, hospitales o cualquier otro lugar público donde no ha respetado medidas de bioseguridad? (distancia mínima y uso de mascarilla)</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question2" id="r3" value="Frecuentó sitios de reisgo" checked>
                        <label class="form-check-label" for="r1">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question2" id="r4" value="no">
                        <label class="form-check-label" for="r2">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Ha estado en contacto con una persona sospechosa y/o confirmada por COVID 19 desde el último test que se ha realizado? </h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question3" id="r5" value="En contacto con sospechoso COVID-19" checked>
                        <label class="form-check-label" for="r1">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question3" id="r6" value="no">
                        <label class="form-check-label" for="r2">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Usted ha estado en fiestas o reuniones sociales donde no se ha respetado el distanciamiento y el uso de mascarilla?</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question4" id="r7" value="Reuniones sociales con riesgo" checked>
                        <label class="form-check-label" for="r1">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question4" id="r8" value="no">
                        <label class="form-check-label" for="r2">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Ha estado expuesto a algún otro factor de riesgo que sea relevante? </h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="r9" value="Otro factor de riesgo" checked>
                        <label class="form-check-label" for="r1">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="r10" value="no">
                        <label class="form-check-label" for="r2">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Usted ha utilizado transporte público para movilizarse donde no se ha respetado el distanciamiento y el uso de mascarilla? </h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question6" id="r11" value="Transporte público - descuido medidas" checked>
                        <label class="form-check-label" for="r1">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question6" id="r12" value="no">
                        <label class="form-check-label" for="r2">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Cuida habitualmente medidas de bioseguridad? (uso de mascarilla, lavado frecuente de manos, uso de alcohol o alcohol gel).</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question7" id="r13" value="No cuida habitualmente medidas" checked>
                        <label class="form-check-label" for="r1">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question7" id="r14" value="no">
                        <label class="form-check-label" for="r2">
                          No
                        </label>
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
