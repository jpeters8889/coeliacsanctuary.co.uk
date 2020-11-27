<html>
<head>
    <title>{{ $recipe->title }} - Coeliac Sanctuary</title>
    <style>
        table, tr, td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td, th {
            padding: 5px;
        }

        h1 {
            margin: 0 0 5px;
        }

        h2 {
            margin: 10px 0 10px;
        }

        img {
            width: 50%;
            height: auto;
        }

        a::after{
            content: " (" attr(href) ") ";
        }
    </style>
</head>
<body onload="window.print()">
<img src="{{ $recipe->main_image }}" alt="{{ $recipe->title }}"
     style="display:inline;float:right;margin:0 0 10px 10px"/>
<h1 class="-articleHeading">{{ $recipe->title }} - Coeliac Sanctuary</h1>
https://www.coeliacsanctuary.co.uk{{ $recipe->link }}
<h2>Posted On: {{ $recipe->created_at->format('jS F Y') }}</h2>
{{ $recipe->description }}<br/>
@if($recipe->features->count() >= 3)
    <h2>This recipe is...</h2>
    {{ $recipe->features->pluck('feature')->join(', ') }}
@endif
<hr class="recHR"/>
<h2 class="recH3">Ingredients</h2>
{!! $recipe->ingredients !!}<br/><br/>
<strong>Preparation Time: </strong> {{ $recipe->prep_time }}<br/>
<strong>Cooking Time: </strong> {{ $recipe->cook_time }}<br/><br/>
<h2 class="recH3">This recipe is free from...</h2>
{{ $recipe->allergens->pluck('allergen')->join(', ') }}
<hr class="recHR"/>
<h2 class="recH3">Method</h2>
{!! $recipe->method !!}

@if($recipe->df_to_not_df)
    <br/><br/>{{ $recipe->df_to_not_df }}
@endif

<hr class="recHR"/>
<h2 class="recH3">This recipe makes {{ $recipe->serving_size }}<br/>Nutritional info per {{ $recipe->per }}</h2>
<table class="nutritional fullTbl">
    <tr>
        <th>Calories</th>
        <th>Carbs</th>
        <th>Fibre</th>
        <th>Fat</th>
        <th>Sugar</th>
        <th>Protein</th>
    </tr>
    <tr>
        <td>{{ $recipe->nutrition->calories }}</td>
        <td>{{ $recipe->nutrition->carbs }}g</td>
        <td>{{ $recipe->nutrition->fibre }}g</td>
        <td>{{ $recipe->nutrition->fat }}g</td>
        <td>{{ $recipe->nutrition->sugar }}g</td>
        <td>{{ $recipe->nutrition->protein }}g</td>
    </tr>
</table>
<p style="text-align:center;">&copy; {{ \Carbon\Carbon::now()->format('Y') }} Coeliac Sanctuary -
    https://www.coeliacsanctuary.co.uk</p>
</body>
</html>
