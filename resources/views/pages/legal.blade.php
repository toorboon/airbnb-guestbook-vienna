@extends('layouts.app')

@section('content')

    <div class="col-md-10 col-12 offset-0 offset-md-1 px-5 px-md-0">
        <h3 class="text-center">Welcome!</h3>
        <div class="row text-justify">
            <p>This application is used as a substitute for the paper-based guestbook the airbnb hosts in Vienna are
                required to keep. Your e-mail address will only be used for sending you a short
                time login link for registering yourself and the fellows travelling with you.</p>
            <p>Your login user will be removed once you are departed. However, the guests personal information will be
                kept seven years after the last entry into this online guestbook was done.</p>
            <p>The requirements for an online guestbook in Vienna can be found here in German language:
                <a href="https://www.wien.gv.at/amtshelfer/wirtschaft/gewerbe/meldepflicht/tourismus/gaeste/gaesteverzeichnis.html" target="_blank">Requirements</a>
            </p>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h5>Informational Links:</h5>
                <ul>
                    <li title="Here you find some information for the necessity of guestbook registration for tourists coming to Vienna!"><a href="https://www.help.gv.at/Portal.Node/hlpd/public/content/118/Seite.11802001.html?fbclid=IwAR1QRvjizsxlDpGXG1kHSTi7kgX7FMY68DAnyuMZaIus1Nkbv1jy7qqIwf4#AdditionalInformation" target="_blank">Registration information in English language (full-time residents and tourists)</a></li>
                    <li title="Some airbnb information about registration in Vienna."><a href="https://www.airbnb.com/help/article/897/vienna?fbclid=IwAR3F5bTWwew6rmmJRnGTq-lJ3oRip2nZp--Y3heZcopMec99pLRcr0gBJqM" target="_blank">AirBnB information about local laws in Vienna</a></li>
                    <li title="As a tourist who is staying less than three months in Vienna your host has to pay a daily visitors tax for you. Information can be found behind this link!"><a href="https://www.wien.gv.at/amtshelfer/finanzielles/rechnungswesen/abgaben/ortstaxe.html#magwienscroll" target="_blank">Taxes</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row text-center">
            <div class="col-12 col-md-5 offset-md-8 mx-auto pt-3 bg-light">
                <h5>Responsible admin for this site</h5>
                <p>Name: {{ ucfirst($responsibleAdmin->name) }}</p>
                <p>E-mail: {{ $responsibleAdmin->email }}</p>
            </div>
        </div>
    </div>
@endsection
