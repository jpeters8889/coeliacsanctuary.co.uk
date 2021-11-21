@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col space-y-3">
        <div class="page-box">
            <h1 class="mb-4 p-3 pt-0 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-blue-light">
                Gluten Free Travel and Translation Cards
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-all" href="/shop">
                    Back to Shop Home
                </a>
            </h6>
        </div>

        <div class="grid gap-3 px-3 lg:grid-cols-2 lg:-mx-3">
            <x-shop.landing-card>
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1198.67 906.27" class="fill-current"
                         lg:max-h-logo>
                        <path
                            d="M230.66,666.29V567.78h-103c-39.87,0-72.33-34.52-72.33-76.95V268.7c0-42.44,32.44-77,72.33-77H588.27c39.87,0,72.3,34.54,72.3,77V490.83c0,42.43-32.43,76.95-72.3,76.95v54c69.64,0,126.3-58.75,126.3-131V268.7c0-72.21-56.65-131-126.3-131H127.66C58,137.73,1.33,196.49,1.33,268.7V490.83c0,72.21,56.67,131,126.33,131h49V717.5a36,36,0,0,0,35.76,35.42,33.93,33.93,0,0,0,26-12.14L339,621.8H439.3v-54H313.91Z"
                            transform="translate(-1.33 -137.73)"/>
                        <path
                            d="M1073.68,428.82H761.84v54h311.84c39.87,0,72.32,34.54,72.32,77V781.9c0,42.44-32.44,77-72.32,77h-103v98.56L887.43,858.9H613.05c-39.86,0-72.3-34.53-72.3-77V559.81c0-42.44,32.44-77,72.3-77v-54c-69.63,0-126.31,58.77-126.31,131V781.91c0,72.25,56.66,131,126.31,131H862.36l100.56,119a34,34,0,0,0,26,12.06,35.14,35.14,0,0,0,12.18-2.19,35.75,35.75,0,0,0,23.63-33.25V912.88h49c69.66,0,126.32-58.75,126.32-131V559.81C1200,487.59,1143.34,428.82,1073.68,428.82Z"
                            transform="translate(-1.33 -137.73)"/>
                        <path
                            d="M318.76,227.06,223.24,478.73h56l19.74-56h94.11l19,56H469.6L375.49,227.06Zm-5.27,154.4,32.78-92.35h.7l31.72,92.35Z"
                            transform="translate(-1.33 -137.73)"/>
                        <path
                            d="M722.23,727.7c0,27.59,17.64,45.49,46.39,45.49,34.55-.73,68.73-22.66,79.85-32.56s41.08-44.36,54.31-71.63c16.73,7.9,24.66,21.14,24.66,35.79,0,31.71-30.54,50.1-79.27,55.68l23.64,32.74c76.33-10,102.3-42.05,102.3-89,0-39.65-25-63.73-56.94-74.27.59-2.91,1.66-6,2.26-8.89l-43.38-7.73c-.29,4.39-1.17,5.19-2,9.59a174.2,174.2,0,0,0-38.46,2.63c0-7.93.29-29.08.59-36.7,36.11-1.46,71.61-4.38,104.49-9.38l-3.82-42.84a691,691,0,0,1-98.33,12c.86-8.53,2.07-32.64,2.07-32.64l-45.81-3.49c-.6,11.75-.86,25.55-1.45,37.57-20.28.29-44.31.29-57,0l2,41.4h5c12,0,31.73-.61,49.36-1.19,0,11.43.28,36.1.58,47.26C751.89,654.87,722.23,686.9,722.23,727.7Zm138-66.35a156.29,156.29,0,0,1-21.72,32.86c-1.2-9.69-1.78-19.66-2.36-30.22C839.35,663.41,852.27,661.35,860.21,661.35Zm-64.59,17c1.47,16.44,3.24,32.29,5.87,46.67-7.62,3.82-14.94,6.17-21.73,6.47-14.69.59-14.69-8.79-14.69-12.92C765.08,703,777.12,688.66,795.62,678.38Z"
                            transform="translate(-1.33 -137.73)"/>
                    </svg>
                </x-slot>
                <x-slot name="title">Professionally Translated</x-slot>
                <x-slot name="body">
                    We don't just run our cards through automated software like Google Translate, all of gluten free
                    travel and translation cards are professionally translated by native speakers, giving you the
                    assurance that anyone reading the card is given accurate information, and that it makes sense!
                </x-slot>
            </x-shop.landing-card>

            <x-shop.landing-card>
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 487.46 430.75"
                         class="fill-current lg:max-h-logo">
                        <polygon
                            points="304.5 353 185.5 353 185.5 0 195.5 0 195.5 343 294.5 343 294.5 0 304.5 0 304.5 353"/>
                        <path d="M654.5,610" transform="translate(-355 -610)"/>
                        <path d="M597,610" transform="translate(-355 -610)"/>
                        <path d="M597,610" transform="translate(-355 -610)"/>
                        <path d="M545.5,610" transform="translate(-355 -610)"/>
                        <path
                            d="M550.32,1001.86a11.36,11.36,0,0,1-2.68,7.82,13.43,13.43,0,0,1-7.61,4.07v.27q6,.76,8.92,3.83a11.26,11.26,0,0,1,2.91,8.07q0,7.14-5,11t-14.08,3.84a41.68,41.68,0,0,1-7.26-.59,24.6,24.6,0,0,1-6.41-2.11v-5.4a32.45,32.45,0,0,0,13.88,3.28q12.94,0,13-10.15,0-9.09-14.29-9.09h-4.92v-4.89h5q5.85,0,9.26-2.58a8.46,8.46,0,0,0,3.42-7.16,7.06,7.06,0,0,0-2.51-5.74,10.35,10.35,0,0,0-6.82-2.09,21.15,21.15,0,0,0-6.19.89,28.4,28.4,0,0,0-6.63,3.28l-2.87-3.82a24.07,24.07,0,0,1,7.1-3.82,25.77,25.77,0,0,1,8.45-1.38q7.29,0,11.32,3.33A11.22,11.22,0,0,1,550.32,1001.86Z"
                            transform="translate(-355 -610)"/>
                        <path
                            d="M609.73,1040.07V1015.7c0-3-.64-5.22-1.92-6.72s-3.26-2.24-5.95-2.24q-5.29,0-7.82,3c-1.69,2-2.53,5.15-2.53,9.36v20.92h-5.68V1015.7c0-3-.63-5.22-1.91-6.72s-3.27-2.24-6-2.24q-5.34,0-7.81,3.2t-2.48,10.48v19.65H562v-37.46h4.61l.92,5.13h.28a11.14,11.14,0,0,1,4.53-4.28,13.87,13.87,0,0,1,6.54-1.54c5.86,0,9.68,2.12,11.49,6.36h.27a12,12,0,0,1,4.85-4.65,15.19,15.19,0,0,1,7.25-1.71q6.36,0,9.52,3.27t3.16,10.44v24.44Z"
                            transform="translate(-355 -610)"/>
                        <path
                            d="M674.84,1040.07V1015.7c0-3-.64-5.22-1.92-6.72s-3.25-2.24-5.94-2.24q-5.31,0-7.83,3c-1.69,2-2.53,5.15-2.53,9.36v20.92H651V1015.7c0-3-.64-5.22-1.92-6.72s-3.27-2.24-6-2.24c-3.55,0-6.16,1.07-7.81,3.2s-2.48,5.62-2.48,10.48v19.65h-5.67v-37.46h4.61l.93,5.13h.27a11.14,11.14,0,0,1,4.53-4.28,13.9,13.9,0,0,1,6.54-1.54q8.79,0,11.49,6.36h.27a12,12,0,0,1,4.85-4.65,15.19,15.19,0,0,1,7.25-1.71q6.36,0,9.52,3.27t3.16,10.44v24.44Z"
                            transform="translate(-355 -610)"/>
                        <rect x="1" y="400.5" width="135" height="5"/>
                        <rect x="0.5" y="229.5" width="5" height="175"/>
                        <rect y="229" width="173.5" height="5"/>
                        <polygon points="182.74 232.37 167.5 217.13 167.5 246.63 182.74 232.37"/>
                        <path d="M520,862.39v-41.3l21.34,21.34Zm5-29.22v17.7l9.15-8.56Z"
                              transform="translate(-355 -610)"/>
                        <rect x="349.96" y="400.48" width="135" height="5"/>
                        <rect x="482.46" y="231.5" width="5" height="172"/>
                        <rect x="313.46" y="228.98" width="173.5" height="5"/>
                        <polygon points="304.22 232.36 319.46 217.11 319.46 246.61 304.22 232.36"/>
                        <path d="M677,862.38l-21.34-20L677,821.08ZM662.81,842.3l9.15,8.55v-17.7Z"
                              transform="translate(-355 -610)"/>
                    </svg>
                </x-slot>
                <x-slot name="title">Ultra thick and durable</x-slot>
                <x-slot name="body">
                    We don't produce our gluten free travel and translation cards on flimsy bits of card, all of our
                    cards are extra thick at 3mm, meaning they're extra durable and will survive your entire trip no
                    matter how many restaurants you take them too!
                </x-slot>
            </x-shop.landing-card>

            <x-shop.landing-card>
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1012.35 1200"
                         class="fill-current lg:max-h-logo">
                        <path
                            d="M109.22,581.19h974.85a18.73,18.73,0,0,0,18.75-18.75V18.75A18.73,18.73,0,0,0,1084.07,0H109.22A18.73,18.73,0,0,0,90.47,18.75V562.44A18.73,18.73,0,0,0,109.22,581.19ZM128,37.5h937.35V543.69H128Z"
                            transform="translate(-90.47 0)"/>
                        <path
                            d="M90.47,1181.25A18.73,18.73,0,0,0,109.22,1200h974.85a18.73,18.73,0,0,0,18.75-18.75V637.56a18.73,18.73,0,0,0-18.75-18.75H109.22a18.73,18.73,0,0,0-18.75,18.75ZM128,656.31h937.35V1162.5H128Z"
                            transform="translate(-90.47 0)"/>
                        <path
                            d="M428.25,224.94A56.25,56.25,0,1,0,372,168.69,56.32,56.32,0,0,0,428.25,224.94Zm0-75a18.75,18.75,0,1,1-18.75,18.75A18.76,18.76,0,0,1,428.25,149.94Z"
                            transform="translate(-90.47 0)"/>
                        <path
                            d="M859.07,452.12a17,17,0,0,0,.39-1.91c0-.55-.28-1-.32-1.54a17.92,17.92,0,0,0-.78-3.92,20.6,20.6,0,0,0-1.2-3.09c-.3-.55-.34-1.18-.68-1.73L687.73,177.75a.91.91,0,0,0-.17-.17,17.65,17.65,0,0,0-2.7-2.77,19.53,19.53,0,0,0-2.57-2.5c-.09-.05-.13-.13-.2-.18a17.66,17.66,0,0,0-2.74-1.07,18.72,18.72,0,0,0-3.79-1.48,16.46,16.46,0,0,0-3.78-.08,17,17,0,0,0-3.42.08,17.91,17.91,0,0,0-3.93,1.51,17.54,17.54,0,0,0-2.65,1c-.07.05-.11.15-.2.2a19.49,19.49,0,0,0-2.46,2.36,19.46,19.46,0,0,0-2.79,2.89c-.06.06-.14.1-.17.17L568.33,314.18l-40.07-61.65c0-.06-.09-.08-.13-.14a21.35,21.35,0,0,0-2.49-2.55,20.47,20.47,0,0,0-2.78-2.73s-.05-.08-.11-.12a20.53,20.53,0,0,0-2.29-.9,18.37,18.37,0,0,0-4.33-1.72,80.14,80.14,0,0,0-7.16,0,18.37,18.37,0,0,0-4.33,1.72,18.76,18.76,0,0,0-2.29.9c-.06,0-.07.1-.11.12a17.5,17.5,0,0,0-2.78,2.73,21.35,21.35,0,0,0-2.49,2.55c0,.06-.09.08-.13.14L375,440a11.9,11.9,0,0,0-.58,1.5,17.23,17.23,0,0,0-1.37,3.45,19.07,19.07,0,0,0-.75,3.71c0,.54-.32,1-.32,1.56s.32,1.2.38,1.85a18.11,18.11,0,0,0,2.14,7,15.55,15.55,0,0,0,2,2.86,17.87,17.87,0,0,0,2.73,2.7c.51.4.81,1,1.35,1.32s1.3.56,1.95.9a19.47,19.47,0,0,0,1.8.82,19,19,0,0,0,6.47,1.3h450a18.58,18.58,0,0,0,2.1-.42,18.27,18.27,0,0,0,3.85-.78,18.8,18.8,0,0,0,2.92-1.33c.41-.23.86-.32,1.26-.57s.56-.63.93-.9a18.75,18.75,0,0,0,3.47-3.37,17.28,17.28,0,0,0,1.52-2.27,18.26,18.26,0,0,0,1.61-3.71A19.58,19.58,0,0,0,859.07,452.12ZM583.71,359.68c.22-.32.39-.62.6-1L672,222.54,806.44,431.47h-269ZM492.9,431.47H425.27l87.32-134.3,33.54,51.62Z"
                            transform="translate(-90.47 0)"/>
                        <path
                            d="M240.41,825a56.25,56.25,0,1,0-56.25-56.25A56.32,56.32,0,0,0,240.41,825Zm0-75a18.75,18.75,0,1,1-18.75,18.75A18.76,18.76,0,0,1,240.41,750Z"
                            transform="translate(-90.47 0)"/>
                        <path class="cls-1" d="M503,750h-150a18.75,18.75,0,0,0,0,37.5H503a18.75,18.75,0,1,0,0-37.5Z"
                              transform="translate(-90.47 0)"/>
                        <path d="M502.93,956.29h-300a18.75,18.75,0,1,0,0,37.5h300a18.75,18.75,0,0,0,0-37.5Z"
                              transform="translate(-90.47 0)"/>
                        <path d="M502.93,1012.54h-300a18.75,18.75,0,1,0,0,37.5h300a18.75,18.75,0,0,0,0-37.5Z"
                              transform="translate(-90.47 0)"/>
                        <path d="M352.91,1068.79h-150a18.75,18.75,0,1,0,0,37.5h150a18.75,18.75,0,1,0,0-37.5Z"
                              transform="translate(-90.47 0)"/>
                        <path d="M746.61,993.79H990.34a18.75,18.75,0,1,0,0-37.5H746.61a18.75,18.75,0,0,0,0,37.5Z"
                              transform="translate(-90.47 0)"/>
                        <path d="M746.61,1050H990.34a18.75,18.75,0,1,0,0-37.5H746.61a18.75,18.75,0,0,0,0,37.5Z"
                              transform="translate(-90.47 0)"/>
                        <path d="M990.47,1068.79H746.61a18.75,18.75,0,0,0,0,37.5H990.47a18.75,18.75,0,1,0,0-37.5Z"
                              transform="translate(-90.47 0)"/>
                        <path d="M690.9,956.29h-.21a18.86,18.86,0,1,0,.21,0Z" transform="translate(-90.47 0)"/>
                        <path d="M690.9,1012.54h-.21a18.86,18.86,0,1,0,.21,0Z" transform="translate(-90.47 0)"/>
                        <path d="M690.9,1068.79h-.21a18.86,18.86,0,1,0,.21,0Z" transform="translate(-90.47 0)"/>
                    </svg>
                </x-slot>
                <x-slot name="title">Double Sided</x-slot>
                <x-slot name="body">
                    Our gluten free travel and translation cards are all double sided, on our standard cards you get two
                    languages, and on our Coeliac and Other Allergy travel cards you have a series of checkboxes to mark
                    any other allergens or foods you can't eat.
                </x-slot>
            </x-shop.landing-card>

            <x-shop.landing-card>
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1191.03 800.22" class="fill-current"
                         lg:max-h-logo>
                        <path
                            d="M1172.42,738.85a18.59,18.59,0,0,1-18.61-18.61V255H521.07V701.63a18.61,18.61,0,1,1-37.21,0V236.39a18.59,18.59,0,0,1,18.61-18.61h670A18.59,18.59,0,0,1,1191,236.39V720.24A18.59,18.59,0,0,1,1172.42,738.85Z"
                            transform="translate(0 -217.78)"/>
                        <path d="M502.47,478.32H335a18.61,18.61,0,0,1,0-37.22H502.47a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path
                            d="M167.49,627.19a18.61,18.61,0,0,1-12.36-32.51L322.62,445.8a18.6,18.6,0,1,1,24.71,27.81L179.85,622.49A18.51,18.51,0,0,1,167.49,627.19Z"
                            transform="translate(0 -217.78)"/>
                        <path d="M483.86,943.56H167.49a18.61,18.61,0,0,1,0-37.22H483.86a18.61,18.61,0,1,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path
                            d="M502.47,720.24a18.61,18.61,0,0,1-12.08-32.77L625.55,572.26a18.6,18.6,0,0,1,24.14,28.3L514.52,715.78A18.36,18.36,0,0,1,502.47,720.24Z"
                            transform="translate(0 -217.78)"/>
                        <path
                            d="M483.84,943.56a18.61,18.61,0,0,1-13.18-31.75l242-242.87A18.6,18.6,0,1,1,739,695.21L497,938.09A18.49,18.49,0,0,1,483.84,943.56Z"
                            transform="translate(0 -217.78)"/>
                        <path d="M1172.42,738.85H687.76a18.61,18.61,0,0,1,0-37.22h484.66a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path
                            d="M167.49,962.17a18.59,18.59,0,0,1-18.61-18.61V571.36a18.61,18.61,0,1,1,37.22,0v372.2A18.59,18.59,0,0,1,167.49,962.17Z"
                            transform="translate(0 -217.78)"/>
                        <path d="M167.49,590H111.66a18.61,18.61,0,1,1,0-37.22h55.83a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path d="M167.49,962.17H111.66a18.61,18.61,0,0,1,0-37.22h55.83a18.61,18.61,0,1,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path
                            d="M111.66,1018h-93a18.61,18.61,0,1,1,0-37.22H93.05V534.14H18.61a18.61,18.61,0,1,1,0-37.21h93.05a18.59,18.59,0,0,1,18.61,18.6V999.39A18.59,18.59,0,0,1,111.66,1018Z"
                            transform="translate(0 -217.78)"/>
                        <path
                            d="M725.78,700.68a18.61,18.61,0,0,1-13.28-31.63,46.53,46.53,0,0,0-63-68.36,18.6,18.6,0,0,1-23.84-28.56,83.74,83.74,0,0,1,113.37,123A18.48,18.48,0,0,1,725.78,700.68Z"
                            transform="translate(0 -217.78)"/>
                        <path
                            d="M789.88,827.55a18.6,18.6,0,0,1-13.44-31.47l84.77-88.7a18.61,18.61,0,0,1,26.89,25.74l-84.77,88.7A18.64,18.64,0,0,1,789.88,827.55Z"
                            transform="translate(0 -217.78)"/>
                        <path
                            d="M744.75,850.51a18.61,18.61,0,1,1,0-37.22c11.22,0,16.75-2.31,32-17.51a18.6,18.6,0,1,1,26.31,26.31C784.61,840.52,769.85,850.51,744.75,850.51Z"
                            transform="translate(0 -217.78)"/>
                        <path
                            d="M696.49,827.55a18.6,18.6,0,0,1-13.44-31.47l84.77-88.7a18.61,18.61,0,0,1,26.89,25.74L710,821.82A18.71,18.71,0,0,1,696.49,827.55Z"
                            transform="translate(0 -217.78)"/>
                        <path
                            d="M651.34,850.51a18.61,18.61,0,0,1,0-37.22c11.23,0,16.75-2.31,32-17.51a18.61,18.61,0,1,1,26.32,26.31C691.22,840.52,676.47,850.51,651.34,850.51Z"
                            transform="translate(0 -217.78)"/>
                        <path d="M744.75,850.51H576.53a18.61,18.61,0,1,1,0-37.22H744.75a18.61,18.61,0,1,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path
                            d="M697.87,496.93a83.75,83.75,0,1,1,83.74-83.75A83.86,83.86,0,0,1,697.87,496.93Zm0-130.27a46.53,46.53,0,1,0,46.52,46.52A46.57,46.57,0,0,0,697.87,366.66Z"
                            transform="translate(0 -217.78)"/>
                        <path d="M1042.15,385.27H856.05a18.61,18.61,0,1,1,0-37.22h186.1a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path d="M1042.15,552.75H911.88a18.61,18.61,0,0,1,0-37.22h130.27a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path d="M949.1,441.1H856.05a18.61,18.61,0,1,1,0-37.22H949.1a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path class="cls-1" d="M856.61,552.75a18.61,18.61,0,0,1-.2-37.22h.2a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path d="M1042.15,627.19H911.88a18.61,18.61,0,0,1,0-37.22h130.27a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                        <path d="M856.61,627.19a18.61,18.61,0,0,1-.2-37.22h.2a18.61,18.61,0,0,1,0,37.22Z"
                              transform="translate(0 -217.78)"/>
                    </svg>
                </x-slot>
                <x-slot name="title">Battle Tested</x-slot>
                <x-slot name="body">
                    We've sold thousands of our gluten free travel and translation cards since we launched our range
                    helping people eat safely all over the world and have received lots of great feedback on our social
                    media platforms, and even from attendees when we have exhibited at various allergy shows around the
                    UK.
                </x-slot>
            </x-shop.landing-card>
        </div>

        <div class="page-box p-3 mt-3">

        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="page-box p-3">
                <h2 class="flex justify-center items-center text-3xl mb-2 font-semibold font-coeliac text-center h-20 border-t border-b border-blue-light">
                    Coeliac Travel Cards
                </h2>

                <div class="flex flex-col space-y-3">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci, amet
                        consectetur distinctio dolorem expedita magni maiores nobis, optio pariatur quae, sequi
                        veritatis? Cumque facilis itaque nihil nostrum, repellendus temporibus!
                    </p>

                    <p>
                        Ab, adipisci aliquid amet aspernatur eaque, enim eveniet fugiat illo ipsum iste labore
                        laboriosam nam nihil nulla odit perferendis quidem repellendus sequi sint suscipit tempore totam
                        voluptate? Officia, sequi, sit?
                    </p>

                    <button
                        class="w-full p-2 bg-blue-light bg-opacity-80 border-blue text-center rounded mt-4 font-semibold hover:bg-blue transition-all">
                        View all Coeliac Travel Cards
                    </button>
                </div>
            </div>

            <div class="page-box p-3">
                <h2 class="flex justify-center items-center text-3xl mb-2 font-semibold font-coeliac text-center h-20 border-t border-b border-blue-light">
                    Coeliac and other Dietary Needs Travel Cards
                </h2>

                <div class="flex flex-col space-y-3">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium adipisci, amet
                        consectetur distinctio dolorem expedita magni maiores nobis, optio pariatur quae, sequi
                        veritatis? Cumque facilis itaque nihil nostrum, repellendus temporibus!
                    </p>

                    <p>
                        Ab, adipisci aliquid amet aspernatur eaque, enim eveniet fugiat illo ipsum iste labore
                        laboriosam nam nihil nulla odit perferendis quidem repellendus sequi sint suscipit tempore totam
                        voluptate? Officia, sequi, sit?
                    </p>

                    <button
                        class="w-full p-2 bg-blue-light bg-opacity-80 border-blue text-center rounded mt-4 font-semibold hover:bg-blue transition-all">
                        View all Coeliac and other Dietary Needs Travel Cards
                    </button>
                </div>
            </div>
        </div>

        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Customer Feedback
            </h1>

            <div class="main-body">
                <p>
                    Thinking of purchasing some of our products, take a look at what some of our previous customers have
                    said about them!
                </p>

                @foreach($feedback as $item)
                    <div class="bg-blue-light bg-opacity-20 border-l-8 border-yellow p-2 mb-4">
                        <em>{{ $item->feedback }}</em><br/>
                        <span class="text-blue">{{ $item->name }} - <a
                                href="{{ $item->product->link }}">{{ $item->product->title }}</a></span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
