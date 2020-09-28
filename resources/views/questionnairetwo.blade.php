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
                        <input class="form-check-input" type="radio" name="question1" id="r1" value="Sí ha presentado síntomas de COVID (fiebre, dolor de cabeza, dolor de garganta, tos, dolor en el pecho, pérdida del olfato o el gusto, vómito, mareo) desde el último test negativo que se ha realizado" checked>
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
                <h3 class="mt-5">¿Usted ha frecuentado bares, restaurantes, hospitales o cualquier otro lugar público y/o privado donde no ha respetado medidas de bioseguridad? (distancia mínima y uso de mascarilla)</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question2" id="r3" value="Sí ha frecuentado bares, restaurantes, hospitales o cualquier otro lugar público y/o privado donde no ha respetado medidas de bioseguridad" checked>
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
                <h3 class="mt-5">¿Ha estado en <strong>"contacto estrecho"</strong>: a menos de dos metros de distancia, con mascarilla y por más de 15 minutos con una persona confirmada de tener actualmente COVID-19 a través de una prueba PCR? </h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question3" id="r5" value="Sí ha estado en 'contacto estrecho': a menos de dos metros de distancia, sin mascarilla y por más de 15 minutos con una persona confirmada de tener actualmente COVID-19 a través de una prueba PCR" checked>
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
                <h3 class="mt-5">¿Usted ha estado en fiestas o reuniones sociales y/o familiares en las que considera que ha estado en <strong>"contacto estrecho"</strong>?</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question4" id="r7" value="Sí ha estado en fiestas o reuniones sociales y/o familiares en las que considera que ha estado en 'contacto estrecho'" checked>
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
                        <input class="form-check-input" type="radio" name="question5" id="r9" value="Sí estado expuesto a algún otro factor de riesgo que sea relevante" checked>
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
                <h3 class="mt-5">¿Usted ha utilizado transporte público, avión o taxi a menos de dos sillas de distancia, en <strong>"contacto estrecho"</strong>?</h3>
                <div class="ml-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question6" id="r11" value="Sí ha utilizado transporte público, avión o taxi a menos de dos sillas de distancia, en contacto estrecho" checked>
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
                        <input class="form-check-input" type="radio" name="question7" id="r13" value="no" checked>
                        <label class="form-check-label" for="r13">
                          Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question7" id="r14" value="No cuida habitualmente medidas de bioseguridad? (uso de mascarilla, lavado frecuente de manos, uso de alcohol o alcohol gel">
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
