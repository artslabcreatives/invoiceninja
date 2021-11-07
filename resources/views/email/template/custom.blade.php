{!! $body !!}
@isset($whitelabel)
    @if(!$whitelabel)
        <table cellpadding="0" cellspacing="0" width="100%">
           <tr>
	            <td>
	                <p>
	                    <a href="https://hypesl.org" target="_blank">
	                        {{ __('texts.ninja_email_footer', ['site' => 'Hype Sri Lanka']) }}
	                    </a>
	                </p>
	            </td>
            </tr>
        </table>
    @endif
@endif