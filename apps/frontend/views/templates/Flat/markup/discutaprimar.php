<div id="firechat" class="dop" style="height: 535px;">
    <div class="top">
        <div class="left firechat-photo" >
            <div class="photo">
                <img src="<?= res('assets/img/small_p.png'); ?>">
            </div>
        </div>

        <div class="right">
            <div class="buttons">
                <button class="firechat-hide"><img src="<?= res('assets/img/save.png'); ?>"></button>
                <button class="firechat-show" style="display: none;"><img src="<?= res('assets/img/unsave.png'); ?>"></button>

                <button class="firechat-close"><img src="<?= res('assets/img/close.png'); ?>"></button>
            </div>
        </div>
        <div class="right firechat-name">
            <p class="c_name">
                Discută on-line cu primarul <span class="firechat-person"></span>
            </p>
            <p class="status on">
                online            </p>
        </div>
        <hr>
    </div>
    <div class="content"><div class="form green">
            <form class="firechat-register" action="" method="">
                <div class="contenta">
                    <label>Funcționar *</label>
                    <select>
                        <option value="32">Nicolae Lungu</option>
                        <option value="32">Nicolae Lungu</option>
                        <option value="32">Nicolae Lungu</option>
                    </select>
                    <label>Nume Prenume * </label>
                    <input name="name" type="text">
                    <label>Email*</label>
                    <input name="email" type="text">    
                    <input type="submit" value="Trimite">
                    <div class="clearfix"></div>
                </div>
            </form>
        </div></div>
</div>
<section>
    <div class="wrap">
        <div class="left_block">
            <p class="title">Audierea cetățenilor</p>
            <ul class="menu">
                <li><a href="javascript:;">Programează-te on-line pentru o audiență  </a></li>
                <li><a href="javascript:;">Orarul audierilor</a></li>
                <li class="active"><a href="javascript:;">Discută on-line cu primarul și consilierii locali </a></li>
                <li><a href="javascript:;">Depune o plângere</a></li>
                <li><a href="javascript:;">Întrebări frecvente </a></li>
            </ul>
        </div>
        <div class="resp_menu"></div>
        <div class="right_block">
            <div class="dirs_menu">
                <a href="javascript:;">Principala »</a>
                <a href="javascript:;">Cetățeni și Business »</a>  
                <a href="javascript:;">Audierea cetățenilor »</a>
                <a href="javascript:;">Discută on-line cu primarul și consilierii locali </a>
            </div>
            <div class="t_block">
                <p>Pentru programarea audiențelor vă rugăm să transmiteți o scurtă prezentare a problemei ce urmează a fi discutată, precum și datele dvs. de contact la adresa de e-mail: relpubl@casan.ro.</p>
                <p>Totodată, puteți să vă adresați telefonic Biroului de Relații cu Asigurații la nr. de telefon: 0372.309.236.</p>
                <p>Confirmarea programării audienței va fi facută telefonic la numărul de telefon indicat de dvs. 
                    o Receptionarea documentelor, care urmeaza a fi examinate în termen de – 1 ora, 24 ore, 5 zile si 15 zile, se va realize fara programare prealabila.</p>
            </div>
            <div class="av pink">
                <p><span>ATENTIE ! </span>Pentru a solicita o audiență la unul din functionar vă rugăm să completați formularul de cerere, iar noi vă vom comunica prin e-mail data și ora audienței programate.</p>
            </div>
            <div class="form green">
                <form class="person_subscribe_form" action="" method="post">
                    <p class="ftb">Programează-te online pentru o audiență</p>
                    <div class="form_error"></div>
                    <div class="content">
                        <label>Funcționar *</label>
                        <select name="person_id">
                            <option value="32">Nicolae Lungu</option>
                            <option value="32">Nicolae Lungu</option>
                            <option value="32">Nicolae Lungu</option>
                        </select>
                        <label>Nume Prenume * </label>
                        <input type="text" name="Nume Prenume">
                        <label>Telefon *</label>
                        <input type="text" name="Telefon">  
                        <label>Email *</label>
                        <input type="text" name="Email">  
                        <label>Cod de verificare *</label>
                        <input class="code" name="capcha" type="text">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAA8CAMAAACac46aAAAAY1BMVEXw8PBvb4Hf3+LPz9S/v8afn6p/f46vr7iPj5xpXka9ubCKgnB5cFublIXOy8Xf3dqsp5tQREPc2tq0r6+gmpmMhIN4b27IxcRkWViGOmCtfpaTUHKgZ4S7lajVwszi2d7Iq7r6U77TAAADsElEQVRYhbWY6ZaCMAyFZSfuRVTEjfd/ykk3KNDSwGB+zEFEPm52ZrPpW7CxGLOdJBmQr7SCF5Pp3HXBM7gO8DLyHO6a4BncMIqDOArXIZO5UZIG0tJ4BTKVm2mqsHyseiaYyI1asYE8SsfXzCITuZmUGYc8ucKEf0j+BabqFSTl3UA9x3+cTc6rOEgjfczrKUewJcGo5Bl1FHf6AvEgQZAtBru5bfICjC/i4GgU5O1uD/sDiQwGYGDyexvVAT7tQBg7OxQYBhpgeyYXVIOHrp5UMNI7n+kEABz416c9g5Pzx26unTlUEEjBpqcxvPLgOHK2jzsttP8ggpsaZXwE0LgdTOZXH0FnSnA+7NVngGN7yCZ83WFmCN2IoZjlvFUPptOhu8cWJiRDByUzhcV6UCRZbCre6RALrzvBMFdoa5GZZ0mH3nfgE+b3mFxcyutCprAQxeZJkOQS3XZvgN2mOz4MO+f9JpvLdSGWk/kf0UDEUNaa++BdDyyZ1Q3K8rIcvNFgOZ9yB1iThXNvjN3urn5VP1/vz3cWODQkD12N4DaiJeMudgX3+eD2rN8fMnjD1xBVVYPkMrOoQL0Tc7CpXw9lr7rxSFdgY0505dQK1WG+MlZ45v6nqZ8KXlPBql+LBiKZ2EC2JrhCwZQi+rxfSH9PXxQMwefOuW33lGT0dElddBBM8nUmYywXAGNIKK9L8IWxO2D/uF69xVQ/Ho3nEglOxWIk1RhjUQ5mTcachgILStgkusH08nAFWMjUdcwjqxYB6BYBJsBwr1h1LUtOL933/GJReeuZM7Nez0QPw/68Pe87nyswNi2ltKjQ7c57YoAdpRxFmglBKDumuXSpZa91tCID62h35u7WtTujM3HfLM6yRI2n/l4t19ujeQr7V2nC0NuOmzsDLHT2LY+sV/Z/xrO6S6mSNxObYYBtlSRTNzapaULAIpcNwfYgvyYrKcqSPE3THAcyhSoaNCvMVHaB375eqc35HjDkIpm3TG1Xu6s/WEmkO9LAsrMwUyUWtOXCr7uSloB1f8ZyqpTM0t5BXt7ZMAfczQVO5poL5NoEv92tkg0tMD94uMLZuHJVhnTTPpRWqa2nePRYaGA7aTEZ4IbK9bq6P3+ZWKsvtkLyPdZM8HDuT7zFNeRKIoBH+4YbjAGmVpIfbNlz3ORv08zgTpKt+9Xy/9+Twfa97vdg1z65FtkFdu6xPwZP7M8rke3gyb19HbIVPP2+8Duw7z1lFbIF7H0/+hGY8F42m/wHjlE3HncF7MwAAAAASUVORK5CYII=" height="31">
                        <input type="submit" value="Trimite">
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <table>
                <tr>
                    <td>
                        <div class="fb-like"  data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    </td>
                    <td>
                        <a href="https://twitter.com/" class="twitter-share-button" >Tweet</a>
                    </td>
                    <td>
                        <div id="ok_shareWidget"></div>                       

                    </td>
                </tr>
            </table>
        </div>
    </div>

</section>

