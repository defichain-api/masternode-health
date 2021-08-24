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
    <script src="{{ asset("vendor/scribe/js/theme-default-3.8.0.js") }}"></script>

    <link rel="stylesheet"
          href="//unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="//unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>


</head>

<body data-languages="[&quot;php&quot;,&quot;javascript&quot;,&quot;python&quot;,&quot;bash&quot;]">
<a href="#" id="nav-button">
      <span>
        MENU
        <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
      </span>
</a>
<div class="tocify-wrapper">
                <div class="lang-selector">
                            <a href="#" data-language-name="php">php</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                            <a href="#" data-language-name="python">python</a>
                            <a href="#" data-language-name="bash">bash</a>
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
            <li>Last updated: August 24 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>The following endpoints are used for setup an API key and to fetch the information for it. You need to use the server script installed as cron on your server - you'll find it on <a href="https://github.com/defichain-api/masternode-health-server">https://github.com/defichain-api/masternode-health-server</a>.</p>
<p>This documentation aims to provide all the information you need to work with this API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://api.defichain-masternode-health.com</code></pre>

        <h1>Authenticating requests</h1>
<p>To authenticate requests, include a <strong><code>x-api-key</code></strong> header with the value <strong><code>"YOUR_API_KEY"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>For &quot;how to create this credential&quot; take a look at the <b>Setup</b> section of this documentation.</p>

        <h1 id="setup">Setup</h1>

    

            <h2 id="setup-POSTsetup-api_key">Get an API Key</h2>

<p>
</p>

<p>create a new API key.</p>

<span id="example-requests-POSTsetup-api_key">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/setup/api_key',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/setup/api_key"
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

url = 'https://api.defichain-masternode-health.com/setup/api_key'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/setup/api_key" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-POSTsetup-api_key">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;API key generated&quot;,
    &quot;api_key&quot;: &quot;c7654335-3e00-41ee-a879-3011c5399d89&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTsetup-api_key" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTsetup-api_key"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTsetup-api_key"></code></pre>
</span>
<span id="execution-error-POSTsetup-api_key" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTsetup-api_key"></code></pre>
</span>
<form id="form-POSTsetup-api_key" data-method="POST"
      data-path="setup/api_key"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTsetup-api_key', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>setup/api_key</code></b>
        </p>
                    </form>

            <h2 id="setup-GETping">Ping</h2>

<p>
</p>

<p>Test the availability of this API.</p>

<span id="example-requests-GETping">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/ping',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/ping"
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

url = 'https://api.defichain-masternode-health.com/ping'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/ping" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GETping">
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
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;pong&quot;,
    &quot;server_time&quot;: &quot;2021-08-24T16:03:28.182894Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETping" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETping"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETping"></code></pre>
</span>
<span id="execution-error-GETping" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETping"></code></pre>
</span>
<form id="form-GETping" data-method="GET"
      data-path="ping"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETping', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>ping</code></b>
        </p>
                    </form>

        <h1 id="server-script">Server-Script</h1>

    

            <h2 id="server-script-POSTv1-server-stats">Server Stats</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint collects (hardware) information from your server.</p>
<aside class="notice">You don't need to implement this endpoint. It's used by the server script and
documented here for a transparent look inside this tool.</aside>

<span id="example-requests-POSTv1-server-stats">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/v1/server-stats',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'cpu' =&gt; 0.23,
            'hdd_used' =&gt; 152.0,
            'hdd_total' =&gt; 508.76,
            'ram_used' =&gt; 1.5,
            'ram_total' =&gt; 16.23,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/server-stats"
);

const headers = {
    "x-api-key": "YOUR_API_KEY",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cpu": 0.23,
    "hdd_used": 152,
    "hdd_total": 508.76,
    "ram_used": 1.5,
    "ram_total": 16.23
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/server-stats'
payload = {
    "cpu": 0.23,
    "hdd_used": 152,
    "hdd_total": 508.76,
    "ram_used": 1.5,
    "ram_total": 16.23
}
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>

<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/v1/server-stats" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"cpu\": 0.23,
    \"hdd_used\": 152,
    \"hdd_total\": 508.76,
    \"ram_used\": 1.5,
    \"ram_total\": 16.23
}"
</code></pre>
</span>

<span id="example-responses-POSTv1-server-stats">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;ok&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTv1-server-stats" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTv1-server-stats"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTv1-server-stats"></code></pre>
</span>
<span id="execution-error-POSTv1-server-stats" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTv1-server-stats"></code></pre>
</span>
<form id="form-POSTv1-server-stats" data-method="POST"
      data-path="v1/server-stats"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTv1-server-stats', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>v1/server-stats</code></b>
        </p>
                <p>
            <label id="auth-POSTv1-server-stats" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="POSTv1-server-stats"
                                                                data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>cpu</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="cpu"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Current average load as float.</p>        </p>
                <p>
            <b><code>hdd_used</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="hdd_used"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Used HDD memory as float.</p>        </p>
                <p>
            <b><code>hdd_total</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="hdd_total"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Total available HDD memory as float.</p>        </p>
                <p>
            <b><code>ram_used</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="ram_used"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Used RAM in GB as float.</p>        </p>
                <p>
            <b><code>ram_total</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="ram_total"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Total available RAM in GB as float.</p>        </p>
    
    </form>

            <h2 id="server-script-POSTv1-node-info">Fullnode Info</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint collects information from your running fullnode.</p>
<aside class="notice">You don't need to implement this endpoint. It's used by the server script and
documented here for a transparent look inside this tool.</aside>

<span id="example-requests-POSTv1-node-info">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/v1/node-info',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'connectioncount' =&gt; 2,
            'block_diff' =&gt; 14,
            'block_height_local' =&gt; 17,
            'main_net_block_height' =&gt; 6,
            'local_hash' =&gt; 'aperiam',
            'main_net_block_hash' =&gt; 'atque',
            'local_split_found' =&gt; false,
            'logsize' =&gt; 7,
            'node_uptime' =&gt; 1343121,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/node-info"
);

const headers = {
    "x-api-key": "YOUR_API_KEY",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "connectioncount": 2,
    "block_diff": 14,
    "block_height_local": 17,
    "main_net_block_height": 6,
    "local_hash": "aperiam",
    "main_net_block_hash": "atque",
    "local_split_found": false,
    "logsize": 7,
    "node_uptime": 1343121
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/node-info'
payload = {
    "connectioncount": 2,
    "block_diff": 14,
    "block_height_local": 17,
    "main_net_block_height": 6,
    "local_hash": "aperiam",
    "main_net_block_hash": "atque",
    "local_split_found": false,
    "logsize": 7,
    "node_uptime": 1343121
}
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>

<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/v1/node-info" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"connectioncount\": 2,
    \"block_diff\": 14,
    \"block_height_local\": 17,
    \"main_net_block_height\": 6,
    \"local_hash\": \"aperiam\",
    \"main_net_block_hash\": \"atque\",
    \"local_split_found\": false,
    \"logsize\": 7,
    \"node_uptime\": 1343121
}"
</code></pre>
</span>

<span id="example-responses-POSTv1-node-info">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;ok&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTv1-node-info" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTv1-node-info"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTv1-node-info"></code></pre>
</span>
<span id="execution-error-POSTv1-node-info" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTv1-node-info"></code></pre>
</span>
<form id="form-POSTv1-node-info" data-method="POST"
      data-path="v1/node-info"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTv1-node-info', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>v1/node-info</code></b>
        </p>
                <p>
            <label id="auth-POSTv1-node-info" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="POSTv1-node-info"
                                                                data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>connectioncount</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="connectioncount"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
        </p>
                <p>
            <b><code>block_diff</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="block_diff"
               data-endpoint="POSTv1-node-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>block_height_local</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="block_height_local"
               data-endpoint="POSTv1-node-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>main_net_block_height</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="main_net_block_height"
               data-endpoint="POSTv1-node-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>local_hash</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="local_hash"
               data-endpoint="POSTv1-node-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>main_net_block_hash</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="main_net_block_hash"
               data-endpoint="POSTv1-node-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>local_split_found</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
                <label data-endpoint="POSTv1-node-info" hidden>
            <input type="radio" name="local_split_found"
                   value="true"
                   data-endpoint="POSTv1-node-info"
                   data-component="body" required             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTv1-node-info" hidden>
            <input type="radio" name="local_split_found"
                   value="false"
                   data-endpoint="POSTv1-node-info"
                   data-component="body" required             >
            <code>false</code>
        </label>
    <br>
        </p>
                <p>
            <b><code>logsize</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="logsize"
               data-endpoint="POSTv1-node-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>node_uptime</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="node_uptime"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>Uptime of the fullnode in seconds.</p>        </p>
    
    </form>

    

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="php">php</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                                    <a href="#" data-language-name="python">python</a>
                                    <a href="#" data-language-name="bash">bash</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var exampleLanguages = ["php","javascript","python","bash"];
        setupLanguages(exampleLanguages);
    });
</script>
</body>
</html>