@extends('layouts.app')

@section('main-content')
    <div id="app" class="row">
        <div class="col-md-12">
            <h1>Términos y Condiciones</h1>
            <p class="mt-4">Reconozco que he leído, comprendo y acepto los siguientes términos y condiciones:</p>
            <ol>
                <li>Declaro que el proceso de retorno a la presencialidad ofrecido por IDE Business School es plenamente voluntario y que IDE Business School mantiene operativos todos los servicios educativos en sus plataformas digitales a las que puedo seguir accediendo como alternativa principal.</li>
                <li>Declaro que conozco los riesgos existentes de acudir de forma personal y presencial a las instalaciones de IDE Business School a pesar de todas las medidas de seguridad adoptadas, liberando de toda responsabilidad de cualquier tipo a IDE Business School, la Universidad de Los Hemisferios y cualquiera de sus directivos, profesores o personal administrativo por cualquier suceso que se pudiese producir y que afecte a mi salud o a la de mis familiares y amigos.</li>
                <li>Declaro que IDE Business School ha adoptado los protocolos de seguridad necesarios para ofrecer la opción voluntaria de retorno a la presencialidad de sus estudiantes, especialmente, sin imponer esta opción a ninguno de los estudiantes.</li>
                <li>Declaro que IDE Business School o la Universidad de Los Hemisferios, así como cualquiera de sus directivos, profesores o personal administrativo, no serán responsables por mi tratamiento médico o el de mis familiares o amigos en caso de obtener un resultado positivo de Covid-19 luego de realizadas las evaluaciones médicas correspondientes.</li>
                <li>Declaro mantener completa confidencialidad respecto a los protocolos utilizados por IDE Business School o la Universidad de Los Hemisferios, responsabilizándome por los daños y perjuicios que pudiese ocasionar en caso de divulgar o arremeter acciones en su contra como resultado del proceso de retorno a la presencialidad que he aceptado previamente.</li>
                <li>Autorizo a Veris a transmitir a IDE Business School los resultados de las pruebas rápidas realizadas con las órdenes emitidas a través de los procesos establecidos en este protocolo.</li>
            </ol>
            <form method="POST" action="/enrollsubmit">
                @csrf

                <input type="checkbox" name="acceptance" value="checked"> Acepto los términos y condiciones descritos en este documento de descargo de responsabilidad
                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>



        </div>
    </div>
@endsection
