@if($eatery)
    <mj-wrapper>
        <mj-section class="no-padding">
            <mj-column>
                <mj-text class="blue-links">
                    <h3 style="font-size:1.5rem" class="blue-links">
                        <a href="{{ config('app.url').$eatery->link() }}" class="blue-links">{{ $eatery->name }}</a>
                    </h3>
                </mj-text>
                <mj-text class="blue-links" padding-top="4px">
                    <h4 style="margin:0">
                        <a href="{{ config('app.url').$eatery->town->updatableLink() }}">{{ $eatery->town->town }}</a>,
                        <a href="{{ config('app.url').$eatery->county->updatableLink() }}">{{ $eatery->county->county }}</a>
                    </h4>
                </mj-text>
                <mj-text class="blue-links" padding-top="10px">
                    {{ $eatery->info }}
                </mj-text>

                @if($eatery->userReviews->count() > 0)
                    <mj-text class="blue-links" padding-top="10px">
                        Rated <strong style="font-weight: bold">{{ $eatery->average_rating }} stars</strong> from {{ $eatery->userReviews->count() }} ratings.
                    </mj-text>
                @endif
            </mj-column>
        </mj-section>
    </mj-wrapper>
@else
    <mj-text></mj-text>
@endif
