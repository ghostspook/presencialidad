@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <form method="POST" class="form" action="{{ route('questionnaireTwoSubmit') }}">
                @csrf
                <h1 class="title text-center mb-5">Cuestionario para obtener autorización de ingreso</h1>
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
                        <label class="form-check-label" for="r3">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question2" id="r4" value="no">
                        <label class="form-check-label" for="r4">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Ha estado en <strong>"contacto estrecho"</strong> a menos de dos metros de distancia, con mascarilla y por más de 15 minutos con una persona confirmada por PCR de tener actualmente COVID-19? </h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question3" id="r5" value="En contacto con sospechoso COVID-19" checked>
                        <label class="form-check-label" for="r5">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question3" id="r6" value="no">
                        <label class="form-check-label" for="r6">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Usted ha estado en fiestas o reuniones sociales y/o familiares en las que considera que ha estado en <strong>"contacto extrecho"</strong>. no se ha respetado el distanciamiento y el uso de mascarilla?</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question4" id="r7" value="Reuniones sociales con riesgo" checked>
                        <label class="form-check-label" for="r7">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question4" id="r8" value="no">
                        <label class="form-check-label" for="r8">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Ha estado expuesto a algún otro factor de riesgo que sea relevante? </h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="r9" value="Otro factor de riesgo" checked>
                        <label class="form-check-label" for="r9">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="r10" value="no">
                        <label class="form-check-label" for="r10">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Usted ha utilizado transporte público, avión o taxi a menos de dos sillas de distancia, en contacto estrecho, de una persona confirmada COVID-19 donde no se ha respetó el distanciamiento y el uso de mascarilla por más 15 minutos? <small>Por favor, reflexione y conteste con la más absoluta sinceridad</small></h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question6" id="r11" value="Transporte público - descuido medidas" checked>
                        <label class="form-check-label" for="r11">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question6" id="r12" value="no">
                        <label class="form-check-label" for="r12">
                          No
                        </label>
                    </div>
                </div>
                <h3 class="mt-5">¿Cuida habitualmente medidas de bioseguridad? (uso de mascarilla, lavado frecuente de manos, uso de alcohol o alcohol gel).</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question7" id="r13" value="No cuida habitualmente medidas" checked>
                        <label class="form-check-label" for="r13">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question7" id="r14" value="no">
                        <label class="form-check-label" for="r14">
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
