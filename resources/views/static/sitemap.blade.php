<urlset>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk</loc>
        <changefreq>always</changefreq>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/about</loc>
        <changefreq>monthly</changefreq>
        <priority>0.25</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/faq</loc>
        <changefreq>monthly</changefreq>
        <priority>0.25</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/work-with-us</loc>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/wheretoeat/coeliac-sanctuary-on-the-go</loc>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/info</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/info/coeliac</loc>
        <changefreq>monthly</changefreq>
        <priority>0.25</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/info/shopping-list</loc>
        <changefreq>monthly</changefreq>
        <priority>0.25</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/info/storecupboard-check</loc>
        <changefreq>monthly</changefreq>
        <priority>0.25</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/info/gluten-challenge</loc>
        <changefreq>monthly</changefreq>
        <priority>0.25</priority>
    </url>

    <!-- Blogs -->
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/blog</loc>
        <changefreq>always</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($blogs as $blog)
        <url>
            <loc>https://www.coeliacsanctuary.co.uk/blog/{{ $blog->slug }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.75</priority>
        </url>
    @endforeach

    <!-- Recipes -->
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/recipe</loc>
        <changefreq>always</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($recipes as $recipe)
        <url>
            <loc>https://www.coeliacsanctuary.co.uk/recipe/{{ $recipe->slug }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.75</priority>
        </url>
@endforeach

    <!-- Where To Eat -->
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/eating-out</loc>
        <changefreq>always</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/wheretoeat/map</loc>
        <changefreq>always</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/wheretoeat/nationwide</loc>
        <changefreq>always</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/wheretoeat</loc>
        <changefreq>always</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/wheretoeat/place-request</loc>
        <changefreq>always</changefreq>
        <priority>0.5</priority>
    </url>
    <!-- Counties -->
    @foreach($counties as $county)
        <url>
            <loc>https://www.coeliacsanctuary.co.uk/wheretoeat/{{ $county->slug  }}</loc>
            <changefreq>always</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Towns -->
    @foreach($towns as $town)
        <url>
            <loc>https://www.coeliacsanctuary.co.uk/wheretoeat/{{ $town->county->slug  }}/{{ $town->slug }}</loc>
            <changefreq>always</changefreq>
            <priority>0.75</priority>
        </url>
    @endforeach

    <!-- Reviews -->
    <url>
        <loc>https://www.coeliacsanctuary.co.uk/review</loc>
        <changefreq>always</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($reviews as $review)
        <url>
            <loc>https://www.coeliacsanctuary.co.uk/review/{{ $review->slug }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.75</priority>
        </url>
    @endforeach
</urlset>
