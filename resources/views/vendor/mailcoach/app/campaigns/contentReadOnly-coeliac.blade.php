<x-mailcoach::layout-campaign :title="__('Content')" :campaign="$campaign">
        <x-mailcoach::web-view src="{{ $campaign->webviewUrl() }}"/>
</x-mailcoach::layout-campaign>
