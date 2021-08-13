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
            <li>Last updated: August 13 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>The following endpoints are used for setup a server and to fetch the information for it. You need to use the bash script installed as cron on your server - you'll find it on <a href="https://github.com/defichain-api/masternode-health-server">https://github.com/defichain-api/masternode-health-server</a>.</p>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://api.defichain-masternode-health.com</code></pre>

        <h1>Authenticating requests</h1>
<p>To authenticate requests, include a <strong><code>x-api-key</code></strong> header with the value <strong><code>"YOUR_API_KEY"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>Additionally you need to add the <code>x-server-key</code> header for a valid authentication.<br></br>For &quot;how to create these credentials&quot; take a look at the <b>Setup</b> section of this documentation.</p>

        <h1 id="endpoints">Endpoints</h1>

    

            <h2 id="endpoints-POSTv1-block-info">POST v1/block-info</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTv1-block-info">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/v1/block-info" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"connectioncount\": 0,
    \"block_diff\": 14,
    \"block_height_local\": 10,
    \"main_net_block_height\": 13,
    \"local_hash\": \"vcgayeyhriwjgyxcjrtgfhtsxhpovaiuujxosehilumszttjp\",
    \"main_net_block_hash\": \"ermtokfbaqvqnfohhwzhavjtrog\",
    \"local_split_found\": false,
    \"logsize\": 3,
    \"node_uptime\": 14
}"
</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/v1/block-info',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'connectioncount' =&gt; 0,
            'block_diff' =&gt; 14,
            'block_height_local' =&gt; 10,
            'main_net_block_height' =&gt; 13,
            'local_hash' =&gt; 'vcgayeyhriwjgyxcjrtgfhtsxhpovaiuujxosehilumszttjp',
            'main_net_block_hash' =&gt; 'ermtokfbaqvqnfohhwzhavjtrog',
            'local_split_found' =&gt; false,
            'logsize' =&gt; 3,
            'node_uptime' =&gt; 14,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/block-info"
);

const headers = {
    "x-api-key": "YOUR_API_KEY",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "connectioncount": 0,
    "block_diff": 14,
    "block_height_local": 10,
    "main_net_block_height": 13,
    "local_hash": "vcgayeyhriwjgyxcjrtgfhtsxhpovaiuujxosehilumszttjp",
    "main_net_block_hash": "ermtokfbaqvqnfohhwzhavjtrog",
    "local_split_found": false,
    "logsize": 3,
    "node_uptime": 14
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/block-info'
payload = {
    "connectioncount": 0,
    "block_diff": 14,
    "block_height_local": 10,
    "main_net_block_height": 13,
    "local_hash": "vcgayeyhriwjgyxcjrtgfhtsxhpovaiuujxosehilumszttjp",
    "main_net_block_hash": "ermtokfbaqvqnfohhwzhavjtrog",
    "local_split_found": false,
    "logsize": 3,
    "node_uptime": 14
}
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>
</span>

<span id="example-responses-POSTv1-block-info">
</span>
<span id="execution-results-POSTv1-block-info" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTv1-block-info"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTv1-block-info"></code></pre>
</span>
<span id="execution-error-POSTv1-block-info" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTv1-block-info"></code></pre>
</span>
<form id="form-POSTv1-block-info" data-method="POST"
      data-path="v1/block-info"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTv1-block-info', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>v1/block-info</code></b>
        </p>
                <p>
            <label id="auth-POSTv1-block-info" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="POSTv1-block-info"
                                                                data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>connectioncount</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="connectioncount"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
<p>Must be at least 0.</p>        </p>
                <p>
            <b><code>block_diff</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="block_diff"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>block_height_local</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="block_height_local"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>main_net_block_height</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="main_net_block_height"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>local_hash</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="local_hash"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
<p>Must be at least 64 characters.</p>        </p>
                <p>
            <b><code>main_net_block_hash</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="main_net_block_hash"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
<p>Must be at least 64 characters.</p>        </p>
                <p>
            <b><code>local_split_found</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
                <label data-endpoint="POSTv1-block-info" hidden>
            <input type="radio" name="local_split_found"
                   value="true"
                   data-endpoint="POSTv1-block-info"
                   data-component="body" required             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTv1-block-info" hidden>
            <input type="radio" name="local_split_found"
                   value="false"
                   data-endpoint="POSTv1-block-info"
                   data-component="body" required             >
            <code>false</code>
        </label>
    <br>
        </p>
                <p>
            <b><code>logsize</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="logsize"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>node_uptime</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="node_uptime"
               data-endpoint="POSTv1-block-info"
               data-component="body" required  hidden>
    <br>
        </p>
    
    </form>

            <h2 id="endpoints-POSTv1-server-stats">POST v1/server-stats</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTv1-server-stats">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/v1/server-stats" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"cpu\": \"ullam\",
    \"hdd_used\": \"ab\",
    \"hdd_total\": \"impedit\",
    \"ram_used\": \"quam\",
    \"ram_total\": \"sint\"
}"
</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/v1/server-stats',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'cpu' =&gt; 'ullam',
            'hdd_used' =&gt; 'ab',
            'hdd_total' =&gt; 'impedit',
            'ram_used' =&gt; 'quam',
            'ram_total' =&gt; 'sint',
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
    "cpu": "ullam",
    "hdd_used": "ab",
    "hdd_total": "impedit",
    "ram_used": "quam",
    "ram_total": "sint"
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
    "cpu": "ullam",
    "hdd_used": "ab",
    "hdd_total": "impedit",
    "ram_used": "quam",
    "ram_total": "sint"
}
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>
</span>

<span id="example-responses-POSTv1-server-stats">
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
            <b><code>cpu</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="cpu"
               data-endpoint="POSTv1-server-stats"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>hdd_used</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="hdd_used"
               data-endpoint="POSTv1-server-stats"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>hdd_total</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="hdd_total"
               data-endpoint="POSTv1-server-stats"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>ram_used</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="ram_used"
               data-endpoint="POSTv1-server-stats"
               data-component="body" required  hidden>
    <br>
        </p>
                <p>
            <b><code>ram_total</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="ram_total"
               data-endpoint="POSTv1-server-stats"
               data-component="body" required  hidden>
    <br>
        </p>
    
    </form>

        <h1 id="server">Server</h1>

    

            <h2 id="server-POSTv1-server-rename">Rename server</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Rename a already setup server key. Requires <code>x-api-key</code> and <code>x-server-key</code> header data.</p>

<span id="example-requests-POSTv1-server-rename">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/v1/server/rename" \
    --header "x-api-key: bffd1dfd-63b8-48f2-afe6-f4318cce86ef" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "x-server-key: 05dbded5-0084-40e1-ab4d-064859440369" \
    --data "{
    \"name\": \"My Awesome Server\"
}"
</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/v1/server/rename',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'bffd1dfd-63b8-48f2-afe6-f4318cce86ef',
            'Accept' =&gt; 'application/json',
            'x-server-key' =&gt; '05dbded5-0084-40e1-ab4d-064859440369',
        ],
        'json' =&gt; [
            'name' =&gt; 'My Awesome Server',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/server/rename"
);

const headers = {
    "x-api-key": "bffd1dfd-63b8-48f2-afe6-f4318cce86ef",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "x-server-key": "05dbded5-0084-40e1-ab4d-064859440369",
};

let body = {
    "name": "My Awesome Server"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/server/rename'
payload = {
    "name": "My Awesome Server"
}
headers = {
  'x-api-key': 'bffd1dfd-63b8-48f2-afe6-f4318cce86ef',
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'x-server-key': '05dbded5-0084-40e1-ab4d-064859440369'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>
</span>

<span id="example-responses-POSTv1-server-rename">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;server \&quot;05dbded5-0084-40e1-ab4d-064859440369\&quot; renamed&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTv1-server-rename" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTv1-server-rename"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTv1-server-rename"></code></pre>
</span>
<span id="execution-error-POSTv1-server-rename" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTv1-server-rename"></code></pre>
</span>
<form id="form-POSTv1-server-rename" data-method="POST"
      data-path="v1/server/rename"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"bffd1dfd-63b8-48f2-afe6-f4318cce86ef","Content-Type":"application\/json","Accept":"application\/json","x-server-key":"05dbded5-0084-40e1-ab4d-064859440369"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTv1-server-rename', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>v1/server/rename</code></b>
        </p>
                <p>
            <label id="auth-POSTv1-server-rename" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="POSTv1-server-rename"
                                                                data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>sring</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTv1-server-rename"
               data-component="body" required  hidden>
    <br>
        </p>
    
    </form>

            <h2 id="server-DELETEv1-server-delete">Delete Server</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete and remove all data for the server given with the <code>x-server-key</code> inside the header data</p>

<span id="example-requests-DELETEv1-server-delete">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "https://api.defichain-masternode-health.com/v1/server/delete" \
    --header "x-api-key: bffd1dfd-63b8-48f2-afe6-f4318cce86ef" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "x-server-key: 05dbded5-0084-40e1-ab4d-064859440369"</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://api.defichain-masternode-health.com/v1/server/delete',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'bffd1dfd-63b8-48f2-afe6-f4318cce86ef',
            'Accept' =&gt; 'application/json',
            'x-server-key' =&gt; '05dbded5-0084-40e1-ab4d-064859440369',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/server/delete"
);

const headers = {
    "x-api-key": "bffd1dfd-63b8-48f2-afe6-f4318cce86ef",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "x-server-key": "05dbded5-0084-40e1-ab4d-064859440369",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/server/delete'
headers = {
  'x-api-key': 'bffd1dfd-63b8-48f2-afe6-f4318cce86ef',
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'x-server-key': '05dbded5-0084-40e1-ab4d-064859440369'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre>
</span>

<span id="example-responses-DELETEv1-server-delete">
</span>
<span id="execution-results-DELETEv1-server-delete" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEv1-server-delete"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEv1-server-delete"></code></pre>
</span>
<span id="execution-error-DELETEv1-server-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEv1-server-delete"></code></pre>
</span>
<form id="form-DELETEv1-server-delete" data-method="DELETE"
      data-path="v1/server/delete"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"bffd1dfd-63b8-48f2-afe6-f4318cce86ef","Content-Type":"application\/json","Accept":"application\/json","x-server-key":"05dbded5-0084-40e1-ab4d-064859440369"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEv1-server-delete', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>v1/server/delete</code></b>
        </p>
                <p>
            <label id="auth-DELETEv1-server-delete" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="DELETEv1-server-delete"
                                                                data-component="header"></label>
        </p>
                </form>

            <h2 id="server-GETv1-servers">List servers</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Show all servers connected with your API key. Only requires the <code>x-api-key</code> header data.</p>

<span id="example-requests-GETv1-servers">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/v1/servers" \
    --header "x-api-key: bffd1dfd-63b8-48f2-afe6-f4318cce86ef" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/v1/servers',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'bffd1dfd-63b8-48f2-afe6-f4318cce86ef',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/servers"
);

const headers = {
    "x-api-key": "bffd1dfd-63b8-48f2-afe6-f4318cce86ef",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/servers'
headers = {
  'x-api-key': 'bffd1dfd-63b8-48f2-afe6-f4318cce86ef',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
</span>

<span id="example-responses-GETv1-servers">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;name&quot;: &quot;Party server&quot;,
            &quot;server_id&quot;: &quot;00ebd742-8c6b-4a64-af43-c8942530c444&quot;,
            &quot;created_at&quot;: &quot;2021-07-18T19:23:31.000000Z&quot;
        },
        {
            &quot;name&quot;: &quot;My awesome 2nd server&quot;,
            &quot;server_id&quot;: &quot;063e8f8b-1eba-4741-82ec-608319c92705&quot;,
            &quot;created_at&quot;: &quot;2021-08-11T05:44:45.000000Z&quot;
        }
    ],
    &quot;info&quot;: {
        &quot;count&quot;: 2
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETv1-servers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETv1-servers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-servers"></code></pre>
</span>
<span id="execution-error-GETv1-servers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-servers"></code></pre>
</span>
<form id="form-GETv1-servers" data-method="GET"
      data-path="v1/servers"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"bffd1dfd-63b8-48f2-afe6-f4318cce86ef","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETv1-servers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>v1/servers</code></b>
        </p>
                <p>
            <label id="auth-GETv1-servers" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="GETv1-servers"
                                                                data-component="header"></label>
        </p>
                </form>

        <h1 id="setup">Setup</h1>

    

            <h2 id="setup-POSTsetup-api_key">Get an API Key</h2>

<p>
</p>

<p>create a new API key.</p>

<span id="example-requests-POSTsetup-api_key">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/setup/api_key" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

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

            <h2 id="setup-POSTsetup-server_key">Get a server key</h2>

<p>
</p>

<p>Create a key for your fullnode / masternode server. You need to generate an API key before.</p>

<span id="example-requests-POSTsetup-server_key">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/setup/server_key" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"api_key\": \"c7654335-3e00-41ee-a879-3011c5399d89\",
    \"name\": \"My Masternode\"
}"
</code></pre>

<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/setup/server_key',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'api_key' =&gt; 'c7654335-3e00-41ee-a879-3011c5399d89',
            'name' =&gt; 'My Masternode',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/setup/server_key"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "api_key": "c7654335-3e00-41ee-a879-3011c5399d89",
    "name": "My Masternode"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/setup/server_key'
payload = {
    "api_key": "c7654335-3e00-41ee-a879-3011c5399d89",
    "name": "My Masternode"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>
</span>

<span id="example-responses-POSTsetup-server_key">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;server key generated&quot;,
    &quot;server_key&quot;: &quot;136b4844-f7b3-4b02-8f32-2ade39264c83&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTsetup-server_key" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTsetup-server_key"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTsetup-server_key"></code></pre>
</span>
<span id="execution-error-POSTsetup-server_key" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTsetup-server_key"></code></pre>
</span>
<form id="form-POSTsetup-server_key" data-method="POST"
      data-path="setup/server_key"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTsetup-server_key', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>setup/server_key</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>api_key</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="api_key"
               data-endpoint="POSTsetup-server_key"
               data-component="body" required  hidden>
    <br>
<p>Your API key</p>        </p>
                <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTsetup-server_key"
               data-component="body"  hidden>
    <br>
<p>Name of this node server</p>        </p>
    
    </form>

            <h2 id="setup-GETping">Ping</h2>

<p>
</p>

<p>Test the availability of this API.</p>

<span id="example-requests-GETping">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/ping" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

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
x-ratelimit-remaining: 59
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;pong&quot;,
    &quot;server_time&quot;: &quot;2021-08-13T14:38:57.832208Z&quot;
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