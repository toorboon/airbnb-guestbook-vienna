@extends('layouts.app')

@section('content')

    <div class="col-md-10 col-12 offset-0 offset-md-1 px-5 px-md-0">
        <h3 class="text-center">Dear Admin!</h3>
        <div class="row text-justify">
            <p>What you see here is the result of me being annoyed by the necessary guest
                registration on paper you have to do here in Vienna. The application you are
                using right now is open-source and published under AGPL-3.0 on Github here:
                <a href="https://github.com/toorboon/airbnb_guestbook" target="_blank">github.com/toorboon.</a>
            </p>
            <p>Even though I followed the requirements posted by the city of Vienna
                <a href="https://www.wien.gv.at/amtshelfer/wirtschaft/gewerbe/meldepflicht/tourismus/gaeste/gaesteverzeichnis.html" target="_blank">here</a>.
                I <strong>cannot</strong> held anyhow responsible for the use of this software!</p>

            <p>You want to contact me or know more about me? Check this out: <a href="http://marcohaefner.de/" target="_blank">Profilepage</a></p>
        </div>
        <hr>
        <div class="row ">
            <div class="col-12">
                <h5>Useful Links:</h5>
                <ul>
                    <li title="Here you find some information for the necessity of guestbook registration for tourists coming to Vienna! This link is shared with your guests if you invite them to the app!"><a href="https://www.help.gv.at/Portal.Node/hlpd/public/content/118/Seite.11802001.html?fbclid=IwAR1QRvjizsxlDpGXG1kHSTi7kgX7FMY68DAnyuMZaIus1Nkbv1jy7qqIwf4#AdditionalInformation" target="_blank">Registration information in English language (full-time residents and tourists)</a></li>
                    <li title="Some airbnb information about the latter links."><a href="https://www.airbnb.com/help/article/897/vienna?fbclid=IwAR3F5bTWwew6rmmJRnGTq-lJ3oRip2nZp--Y3heZcopMec99pLRcr0gBJqM" target="_blank">AirBnB information about local laws in Vienna</a></li>
                    <li title="The law requires you to post every month a statistic of your guests for the city records. Information can be found behind this link!"><a href="https://www.wien.gv.at/toust/betrieb/MonatsStatExtern.aspx" target="_blank">Nächtigungsstatistik, Due-Date: 1st-5th</a></li>
                    <li title="If your guest stays at your airbnb for less than three months, you have to pay a tax for every day the guest stayed to the city. Information can be found behind this link!"><a href="https://www.wien.gv.at/amtshelfer/finanzielles/rechnungswesen/abgaben/ortstaxe.html#magwienscroll" target="_blank">Ortstaxe, Due-Date: 15th</a></li>
                </ul>
            </div>
        </div>
    </div>



@endsection
