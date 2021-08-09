<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>DeFiChain Masternode Health</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.print.css") }}" media="print">
    <script src="{{ asset("vendor/scribe/js/theme-default-3.6.2.js") }}"></script>

    <link rel="stylesheet"
          href="//unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="//unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>


</head>

<body data-languages="[&quot;bash&quot;,&quot;php&quot;,&quot;javascript&quot;,&quot;python&quot;]">
<a href="#" id="nav-button">
      <span>
        MENU
        <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
      </span>
</a>
<div class="tocify-wrapper">
                <div class="lang-selector">
                            <a href="#" data-language-name="bash">bash</a>
                            <a href="#" data-language-name="php">php</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                            <a href="#" data-language-name="python">python</a>
                    </div>
        <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>

    <ul id="toc">
    </ul>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
            <ul class="toc-footer" id="last-updated">
            <li>Last updated: July 19 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>The following endpoints are used for setup a server and how to fetch the information for it. You need to use the bash script installed as cron on your server.</p>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://defichain-masternode-health.com</code></pre>

        <h1>Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

            <h2 id="endpoints-GETapi-ping">GET api/ping</h2>

<p>
</p>



<span id="example-requests-GETapi-ping">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "https://defichain-masternode-health.com/api/ping" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://defichain-masternode-health.com/api/ping',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://defichain-masternode-health.com/api/ping"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://defichain-masternode-health.com/api/ping'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
</span>

<span id="example-responses-GETapi-ping">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 58
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;pong&quot;,
    &quot;server_time&quot;: &quot;2021-07-19T05:26:33.512570Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-ping" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-ping"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ping"></code></pre>
</span>
<span id="execution-error-GETapi-ping" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ping"></code></pre>
</span>
<form id="form-GETapi-ping" data-method="GET"
      data-path="api/ping"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-ping', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ping</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-setup-api_key">POST api/setup/api_key</h2>

<p>
</p>



<span id="example-requests-POSTapi-setup-api_key">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://defichain-masternode-health.com/api/setup/api_key" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://defichain-masternode-health.com/api/setup/api_key',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://defichain-masternode-health.com/api/setup/api_key"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://defichain-masternode-health.com/api/setup/api_key'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
</span>

<span id="example-responses-POSTapi-setup-api_key">
</span>
<span id="execution-results-POSTapi-setup-api_key" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-setup-api_key"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-setup-api_key"></code></pre>
</span>
<span id="execution-error-POSTapi-setup-api_key" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-setup-api_key"></code></pre>
</span>
<form id="form-POSTapi-setup-api_key" data-method="POST"
      data-path="api/setup/api_key"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-setup-api_key', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/setup/api_key</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-setup-server_key">POST api/setup/server_key</h2>

<p>
</p>



<span id="example-requests-POSTapi-setup-server_key">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://defichain-masternode-health.com/api/setup/server_key" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"api_key\": \"a6620043-d8f2-3e8a-8ab6-3f6304daa6da\"
}"
</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://defichain-masternode-health.com/api/setup/server_key',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'api_key' =&gt; 'a6620043-d8f2-3e8a-8ab6-3f6304daa6da',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://defichain-masternode-health.com/api/setup/server_key"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_key": "a6620043-d8f2-3e8a-8ab6-3f6304daa6da"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://defichain-masternode-health.com/api/setup/server_key'
payload = {
    "api_key": "a6620043-d8f2-3e8a-8ab6-3f6304daa6da"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>
</span>

<span id="example-responses-POSTapi-setup-server_key">
</span>
<span id="execution-results-POSTapi-setup-server_key" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-setup-server_key"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-setup-server_key"></code></pre>
</span>
<span id="execution-error-POSTapi-setup-server_key" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-setup-server_key"></code></pre>
</span>
<form id="form-POSTapi-setup-server_key" data-method="POST"
      data-path="api/setup/server_key"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-setup-server_key', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/setup/server_key</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>api_key</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="api_key"
               data-endpoint="POSTapi-setup-server_key"
               data-component="body" required  hidden>
    <br>
<p>Must be a valid UUID.</p>        </p>
    
    </form>

            <h2 id="endpoints-POSTapi-v1-servers">POST api/v1/servers</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-servers">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://defichain-masternode-health.com/api/v1/servers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://defichain-masternode-health.com/api/v1/servers',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://defichain-masternode-health.com/api/v1/servers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://defichain-masternode-health.com/api/v1/servers'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
</span>

<span id="example-responses-POSTapi-v1-servers">
</span>
<span id="execution-results-POSTapi-v1-servers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-servers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-servers"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-servers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-servers"></code></pre>
</span>
<form id="form-POSTapi-v1-servers" data-method="POST"
      data-path="api/v1/servers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-servers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/servers</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-v1-block-info">POST api/v1/block-info</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-block-info">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://defichain-masternode-health.com/api/v1/block-info" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://defichain-masternode-health.com/api/v1/block-info',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://defichain-masternode-health.com/api/v1/block-info"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://defichain-masternode-health.com/api/v1/block-info'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
</span>

<span id="example-responses-POSTapi-v1-block-info">
</span>
<span id="execution-results-POSTapi-v1-block-info" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-block-info"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-block-info"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-block-info" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-block-info"></code></pre>
</span>
<form id="form-POSTapi-v1-block-info" data-method="POST"
      data-path="api/v1/block-info"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-block-info', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/block-info</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-v1-server-stats">POST api/v1/server-stats</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-server-stats">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://defichain-masternode-health.com/api/v1/server-stats" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://defichain-masternode-health.com/api/v1/server-stats',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://defichain-masternode-health.com/api/v1/server-stats"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://defichain-masternode-health.com/api/v1/server-stats'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
</span>

<span id="example-responses-POSTapi-v1-server-stats">
</span>
<span id="execution-results-POSTapi-v1-server-stats" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-server-stats"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-server-stats"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-server-stats" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-server-stats"></code></pre>
</span>
<form id="form-POSTapi-v1-server-stats" data-method="POST"
      data-path="api/v1/server-stats"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-server-stats', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/server-stats</code></b>
        </p>
                    </form>

    

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="php">php</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                                    <a href="#" data-language-name="python">python</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var exampleLanguages = ["bash","php","javascript","python"];
        setupLanguages(exampleLanguages);
    });
</script>
</body>
</html>