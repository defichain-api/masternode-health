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
    <script src="{{ asset("vendor/scribe/js/theme-default-3.9.1.js") }}"></script>

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
            <li>Last updated: September 23 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>This is an open source application to monitor the health status of a masternode server.</p>
<p>Main requirement was to keep everything 100% anonymous for the users to protect their privacy.</p>
<p>This application has two parts:</p>
<ul>
<li>The python script has to be installed on the own server. It collects the information and pushes them (anonymously) to the API</li>
<li>This API receives the (anonymous) information and offers them via GET request (pull) or an optional webhook</li>
</ul>
<p>The server offers an API key (like <code>3a833079-9f2e-4336-a053-7a28808165a4</code>) - that's all you need for the usage.</p>
<p>This API The following endpoints are used for setup an API key and to fetch the information for it. You need to use the server script installed as cron on your server - you'll find it on <a href="https://github.com/defichain-api/masternode-health-server">https://github.com/defichain-api/masternode-health-server</a>.</p>
<p>This documentation aims to provide all the information you need to work with this API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://api.defichain-masternode-health.com</code></pre>

        <h1>Authenticating requests</h1>
<p>This API is authenticated by sending a <strong><code>x-api-key</code></strong> header with the value <strong><code>"YOUR_API_KEY"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>For &quot;how to create this credential&quot; take a look at the <b>Setup</b> section of this documentation.</p>

        <h1 id="setup">Setup</h1>

    

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
x-ratelimit-remaining: 59
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;pong&quot;,
    &quot;server_time&quot;: &quot;2021-09-23T07:55:30.211384Z&quot;
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

            <h2 id="setup-GETsetup-api_key">Get an API Key</h2>

<p>
</p>

<p>create a new API key.</p>
<aside class="warning">Throttle: 1 request every 60 sec.</aside>

<span id="example-requests-GETsetup-api_key">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
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
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/setup/api_key'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/setup/api_key" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GETsetup-api_key">
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
<span id="execution-results-GETsetup-api_key" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETsetup-api_key"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETsetup-api_key"></code></pre>
</span>
<span id="execution-error-GETsetup-api_key" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETsetup-api_key"></code></pre>
</span>
<form id="form-GETsetup-api_key" data-method="GET"
      data-path="setup/api_key"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETsetup-api_key', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>setup/api_key</code></b>
        </p>
                    </form>

            <h2 id="setup-GEThealth">API Health Check</h2>

<p>
</p>

<p>To check the availability of the API, you can setup a ping to this endpoint. It throws a HTTP 500 if a system
is not running well - otherwise it's a HTTP 200.</p>

<span id="example-requests-GEThealth">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/health',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'period'=&gt; '30',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/health"
);

const params = {
    "period": "30",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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

url = 'https://api.defichain-masternode-health.com/health'
params = {
  'period': '30',
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/health?period=30" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GEThealth">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;redis_connection&quot;: true,
    &quot;database_connection&quot;: true,
    &quot;new_data_in_period&quot;: true,
    &quot;server_time&quot;: &quot;2021-09-06T15:46:24.731762Z&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Error):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;redis_connection&quot;: false,
    &quot;database_connection&quot;: true,
    &quot;new_data_in_period&quot;: true,
    &quot;server_time&quot;: &quot;2021-09-06T15:46:24.731762Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GEThealth" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GEThealth"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GEThealth"></code></pre>
</span>
<span id="execution-error-GEThealth" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GEThealth"></code></pre>
</span>
<form id="form-GEThealth" data-method="GET"
      data-path="health"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GEThealth', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>health</code></b>
        </p>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                    <p>
                <b><code>period</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="period"
               data-endpoint="GEThealth"
               data-component="query"  hidden>
    <br>
<p>Check the new data in the given period in minutes (min: 10). Default: 30</p>            </p>
                </form>

    <h3>Response</h3>
    <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
            <p>
            <b><code>redis_connection</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<br>
<p>Check if the redis system is available.</p>        </p>
            <p>
            <b><code>database_connection</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<br>
<p>Check if the database is available.</p>        </p>
            <p>
            <b><code>new_data_in_period</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<br>
<p>Check if new data was pushed to the API in the last 30min.</p>        </p>
            <p>
            <b><code>server_time</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<br>
<p>Current server time</p>        </p>
            <h1 id="pull-information">Pull Information</h1>

    

            <h2 id="pull-information-GETv1-node-info">Fullnode Info</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Pull the latest fullnode info posted to the health API by your server.</p>

<span id="example-requests-GETv1-node-info">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/v1/node-info',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
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

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/node-info'
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/v1/node-info" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GETv1-node-info">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;type&quot;: &quot;config_checksum&quot;,
            &quot;value&quot;: &quot;a3cca2b2aa1e3b5b3b5aad99a8529074&quot;
        },
        {
            &quot;type&quot;: &quot;defid_running&quot;,
            &quot;value&quot;: true
        },
        {
            &quot;type&quot;: &quot;operator_status&quot;,
            &quot;value&quot;: [
                {
                    &quot;id&quot;: &quot;8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87&quot;,
                    &quot;online&quot;: true
                },
                {
                    &quot;id&quot;: &quot;2ceb7c9c3bea0bd0e5e4199eca5d0b797d79a0077a9108951faecf715e1e1a57&quot;,
                    &quot;online&quot;: true
                }
            ]
        },
        {
            &quot;type&quot;: &quot;node_uptime&quot;,
            &quot;value&quot;: 261124
        },
        {
            &quot;type&quot;: &quot;local_hash&quot;,
            &quot;value&quot;: &quot;0d82efc6638c91279e5f493053075226619080515d2f9b583f8cfc42a4f08885&quot;
        },
        {
            &quot;type&quot;: &quot;block_height_local&quot;,
            &quot;value&quot;: 1132261
        },
        {
            &quot;type&quot;: &quot;connection_count&quot;,
            &quot;value&quot;: 91
        },
        {
            &quot;type&quot;: &quot;logsize&quot;,
            &quot;value&quot;: 13.21
        },
        {
            &quot;type&quot;: &quot;node_version&quot;,
            &quot;value&quot;: &quot;1.6.3&quot;
        }
    ],
    &quot;latest_update&quot;: &quot;2021-08-31T14:14:12.000000Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETv1-node-info" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETv1-node-info"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-node-info"></code></pre>
</span>
<span id="execution-error-GETv1-node-info" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-node-info"></code></pre>
</span>
<form id="form-GETv1-node-info" data-method="GET"
      data-path="v1/node-info"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETv1-node-info', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>v1/node-info</code></b>
        </p>
                <p>
            <label id="auth-GETv1-node-info" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="GETv1-node-info"
                                                                data-component="header"></label>
        </p>
                </form>

    <h3>Response</h3>
    <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
            <p>
            <b><code>block_height_local</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<br>
<p>Local Block height</p>        </p>
            <p>
            <b><code>operator_status</code></b>&nbsp;&nbsp;<small>object</small>  &nbsp;
<br>
<p>Lists the masternode id and it's online status</p>        </p>
            <p>
            <b><code>node_uptime</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<br>
<p>Uptime of the node in seconds</p>        </p>
            <p>
            <b><code>node_version</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<br>
<p>Current version of the node</p>        </p>
            <p>
            <b><code>config_checksum</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<br>
<p>MD5 hash of the defi.conf file</p>        </p>
            <p>
            <b><code>local_hash</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<br>
<p>block hash of the current block</p>        </p>
            <p>
            <b><code>connection_count</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<br>
<p>Number of current connections to the node</p>        </p>
            <p>
            <b><code>logsize</code></b>&nbsp;&nbsp;  &nbsp;
<br>
<p>numeric Size of the debug.log in MB</p>        </p>
            <p>
            <b><code>defid_running</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<br>
<p>Flag if the DEFID is running. Example: true</p>        </p>
                <h2 id="pull-information-GETv1-server-stats">Server Stats</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Pull the latest server stats posted to the health API by your server. All data (except load_avg) are in GB.</p>

<span id="example-requests-GETv1-server-stats">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/v1/server-stats',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
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

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/server-stats'
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/v1/server-stats" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GETv1-server-stats">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;type&quot;: &quot;hdd_total&quot;,
            &quot;value&quot;: 933.22
        },
        {
            &quot;type&quot;: &quot;server_script_version&quot;,
            &quot;value&quot;: &quot;1.0.1&quot;
        },
        {
            &quot;type&quot;: &quot;num_cores&quot;,
            &quot;value&quot;: 8
        },
        {
            &quot;type&quot;: &quot;hdd_used&quot;,
            &quot;value&quot;: 53.22
        },
        {
            &quot;type&quot;: &quot;ram_total&quot;,
            &quot;value&quot;: 125.22
        },
        {
            &quot;type&quot;: &quot;load_avg&quot;,
            &quot;value&quot;: 0.22
        },
        {
            &quot;type&quot;: &quot;ram_used&quot;,
            &quot;value&quot;: 2.22
        }
    ],
    &quot;latest_update&quot;: &quot;2021-08-31T14:14:15.000000Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETv1-server-stats" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETv1-server-stats"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-server-stats"></code></pre>
</span>
<span id="execution-error-GETv1-server-stats" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-server-stats"></code></pre>
</span>
<form id="form-GETv1-server-stats" data-method="GET"
      data-path="v1/server-stats"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETv1-server-stats', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>v1/server-stats</code></b>
        </p>
                <p>
            <label id="auth-GETv1-server-stats" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="GETv1-server-stats"
                                                                data-component="header"></label>
        </p>
                </form>

    <h3>Response</h3>
    <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
            <p>
            <b><code>ram_total</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<br>
<p>Available RAM in GB</p>        </p>
            <p>
            <b><code>ram_used</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<br>
<p>Used RAM in GB</p>        </p>
            <p>
            <b><code>hdd_used</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<br>
<p>Available hdd memory in GB</p>        </p>
            <p>
            <b><code>hdd_total</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<br>
<p>Used hdd memory in GB</p>        </p>
            <p>
            <b><code>load_avg</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<br>
<p>Current load avg over the last 5min</p>        </p>
            <p>
            <b><code>num_cores</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<br>
<p>Number of cpu cores</p>        </p>
            <p>
            <b><code>server_script_version</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<br>
<p>Current Version of the server script. Example: 1.0.1</p>        </p>
                <h2 id="pull-information-GETv1-data-status">Data Status</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>You can check the latest state of your stored data. For more details check the output.</p>

<span id="example-requests-GETv1-data-status">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/v1/data-status',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'period'=&gt; '10',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/data-status"
);

const params = {
    "period": "10",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "x-api-key": "YOUR_API_KEY",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/data-status'
params = {
  'period': '10',
}
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/v1/data-status?period=10" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GETv1-data-status">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;new_data_in_period&quot;: 6,
    &quot;latest_data_sent_at&quot;: &quot;2021-09-06T22:16:40.000000Z&quot;,
    &quot;latest_data_diff_minutes&quot;: 4,
    &quot;possible_problem_detected&quot;: false,
    &quot;server_time&quot;: &quot;2021-09-06T22:20:54.430225Z&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (200, Error):</p>
        </blockquote>
                <pre>

<code class="language-json">{&quot;new_data_in_period&quot;:null,&quot;latest_data_sent_at&quot;:&quot;2021-09-06T07:20:54
.430225Z&quot;,
&quot;latest_data_diff_minutes&quot;:932,&quot;possible_problem_detected&quot;:true,&quot;server_time&quot;:&quot;2021-09-06T22:20:54.430225Z&quot;}</code>
 </pre>
    </span>
<span id="execution-results-GETv1-data-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETv1-data-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETv1-data-status"></code></pre>
</span>
<span id="execution-error-GETv1-data-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETv1-data-status"></code></pre>
</span>
<form id="form-GETv1-data-status" data-method="GET"
      data-path="v1/data-status"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETv1-data-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>v1/data-status</code></b>
        </p>
                <p>
            <label id="auth-GETv1-data-status" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="GETv1-data-status"
                                                                data-component="header"></label>
        </p>
                    <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                    <p>
                <b><code>period</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="period"
               data-endpoint="GETv1-data-status"
               data-component="query"  hidden>
    <br>
<p>Check the data in the given period in minutes (min: 5). Default: 10</p>            </p>
                </form>

    <h3>Response</h3>
    <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
            <p>
            <b><code>new_data_in_period</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<br>
<p>Count of new data in the given period</p>        </p>
            <p>
            <b><code>latest_data_sent_at</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<br>
<p>Timestamp of the latest data.</p>        </p>
            <p>
            <b><code>latest_data_diff_minutes</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<br>
<p>Diff in minutes of the latest data.</p>        </p>
            <p>
            <b><code>possible_problem_detected</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<br>
<p>To check the response quickly, this flag indicates if a
possible problem was found.</p>        </p>
            <p>
            <b><code>server_time</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<br>
<p>Current server time</p>        </p>
            <h1 id="server-script">Server-Script</h1>

    

            <h2 id="server-script-POSTv1-server-stats">Server Stats</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint collects (hardware) information from your server.</p>
<aside class="notice">You don't need to implement this endpoint. It's used by the server script and
documented here for a transparent look inside this tool.</aside>
<aside class="warning">Throttle: 1 request every 300 sec.</aside>
<aside class="notice">If you setup the webhooks, you'll receive the "server stats info" payload.</aside>

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
            'load_avg' =&gt; 0.23,
            'num_cores' =&gt; 8,
            'hdd_used' =&gt; 152.0,
            'hdd_total' =&gt; 508.76,
            'ram_used' =&gt; 1.5,
            'ram_total' =&gt; 16.23,
            'server_script_version' =&gt; '1.0.1',
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
    "load_avg": 0.23,
    "num_cores": 8,
    "hdd_used": 152,
    "hdd_total": 508.76,
    "ram_used": 1.5,
    "ram_total": 16.23,
    "server_script_version": "1.0.1"
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
    "load_avg": 0.23,
    "num_cores": 8,
    "hdd_used": 152,
    "hdd_total": 508.76,
    "ram_used": 1.5,
    "ram_total": 16.23,
    "server_script_version": "1.0.1"
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
    \"load_avg\": 0.23,
    \"num_cores\": 8,
    \"hdd_used\": 152,
    \"hdd_total\": 508.76,
    \"ram_used\": 1.5,
    \"ram_total\": 16.23,
    \"server_script_version\": \"1.0.1\"
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
            <b><code>load_avg</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="load_avg"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Current average load in GB as float.</p>        </p>
                <p>
            <b><code>num_cores</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="num_cores"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Number of cores of the system.</p>        </p>
                <p>
            <b><code>hdd_used</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="hdd_used"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Used HDD memory in GB as float.</p>        </p>
                <p>
            <b><code>hdd_total</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="hdd_total"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>Total available HDD in GB memory as float.</p>        </p>
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
                <p>
            <b><code>server_script_version</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="server_script_version"
               data-endpoint="POSTv1-server-stats"
               data-component="body"  hidden>
    <br>
<p>The current version of the python server script.</p>        </p>
    
    </form>

            <h2 id="server-script-POSTv1-node-info">Fullnode Info</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint collects information from your running fullnode.</p>
<aside class="notice">You don't need to implement this endpoint. It's used by the server script and
documented here for a transparent look inside this tool.</aside>
<aside class="warning">Throttle: 1 request every 300 sec.</aside>
<aside class="notice">If you setup the webhooks, you'll receive the "pull node info" payload.</aside>

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
            'block_height_local' =&gt; 1131998,
            'local_hash' =&gt; 'cefe56ff49a94787a8e8c65da5c4ead6e748838ece6721a06624de15875395a3',
            'node_uptime' =&gt; 1343121,
            'connection_count' =&gt; 91,
            'logsize' =&gt; 13.21,
            'config_checksum' =&gt; 'a3cca2b2aa1e3b5b3b5aad99a8529074',
            'node_version' =&gt; '1.6.3',
            'operator_status' =&gt; [
                [
                    'id' =&gt; '8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87',
                    'online' =&gt; false,
                ],
            ],
            'defid_running' =&gt; true,
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
    "block_height_local": 1131998,
    "local_hash": "cefe56ff49a94787a8e8c65da5c4ead6e748838ece6721a06624de15875395a3",
    "node_uptime": 1343121,
    "connection_count": 91,
    "logsize": 13.21,
    "config_checksum": "a3cca2b2aa1e3b5b3b5aad99a8529074",
    "node_version": "1.6.3",
    "operator_status": [
        {
            "id": "8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87",
            "online": false
        }
    ],
    "defid_running": true
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
    "block_height_local": 1131998,
    "local_hash": "cefe56ff49a94787a8e8c65da5c4ead6e748838ece6721a06624de15875395a3",
    "node_uptime": 1343121,
    "connection_count": 91,
    "logsize": 13.21,
    "config_checksum": "a3cca2b2aa1e3b5b3b5aad99a8529074",
    "node_version": "1.6.3",
    "operator_status": [
        {
            "id": "8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87",
            "online": false
        }
    ],
    "defid_running": true
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
    \"block_height_local\": 1131998,
    \"local_hash\": \"cefe56ff49a94787a8e8c65da5c4ead6e748838ece6721a06624de15875395a3\",
    \"node_uptime\": 1343121,
    \"connection_count\": 91,
    \"logsize\": 13.21,
    \"config_checksum\": \"a3cca2b2aa1e3b5b3b5aad99a8529074\",
    \"node_version\": \"1.6.3\",
    \"operator_status\": [
        {
            \"id\": \"8cb09568143d7bae6822a7a78f91cb907c23fd12dcf986d4d2c8de89457edf87\",
            \"online\": false
        }
    ],
    \"defid_running\": true
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
            <b><code>block_height_local</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="block_height_local"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>The number of the current block.</p>        </p>
                <p>
            <b><code>local_hash</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="local_hash"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>Hash for the current block. Required length of 64 chars.</p>        </p>
                <p>
            <b><code>node_uptime</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="node_uptime"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>Uptime of the fullnode in seconds.</p>        </p>
                <p>
            <b><code>connection_count</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="connection_count"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>Count of the current fullnode connections.</p>        </p>
                <p>
            <b><code>logsize</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="logsize"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>Size of the debug.log file in MB.</p>        </p>
                <p>
            <b><code>config_checksum</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="config_checksum"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>MD5 Hash of the defi.conf file.</p>        </p>
                <p>
            <b><code>node_version</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="node_version"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>DeFiChain Node Version.</p>        </p>
                <p>
        <details>
            <summary style="padding-bottom: 10px;">
                <b><code>operator_status</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>
<p>Online/Offline information for all masternodes registered on the
fullnode.</p>            </summary>
                                                <p>
                        <b><code>operator_status[].id</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="operator_status.0.id"
               data-endpoint="POSTv1-node-info"
               data-component="body"  hidden>
    <br>
<p>Masternode ID</p>                    </p>
                                                                <p>
                        <b><code>operator_status[].online</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
                <label data-endpoint="POSTv1-node-info" hidden>
            <input type="radio" name="operator_status.0.online"
                   value="true"
                   data-endpoint="POSTv1-node-info"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTv1-node-info" hidden>
            <input type="radio" name="operator_status.0.online"
                   value="false"
                   data-endpoint="POSTv1-node-info"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
                    </p>
                                    </details>
        </p>
                <p>
            <b><code>defid_running</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
                <label data-endpoint="POSTv1-node-info" hidden>
            <input type="radio" name="defid_running"
                   value="true"
                   data-endpoint="POSTv1-node-info"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTv1-node-info" hidden>
            <input type="radio" name="defid_running"
                   value="false"
                   data-endpoint="POSTv1-node-info"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Check if the DEFID on the server is running</p>        </p>
    
    </form>

        <h1 id="webhooks">Webhooks</h1>

    

            <h2 id="webhooks-POSTv1-webhook">Create Webhook</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get informed by webhooks with the current data of your server. You'll receive webhooks only every 5 minutes.</p>
<aside class="notice">The sent webhooks have the same markup as the pulled information for the node info and server stats
.</aside>

<span id="example-requests-POSTv1-webhook">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://api.defichain-masternode-health.com/v1/webhook',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'url' =&gt; 'https://your-domain.com/defichain-masternode-health/webhook',
            'max_tries' =&gt; 3,
            'timeout_in_seconds' =&gt; 3,
            'reference' =&gt; 'eum',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/webhook"
);

const headers = {
    "x-api-key": "YOUR_API_KEY",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "url": "https:\/\/your-domain.com\/defichain-masternode-health\/webhook",
    "max_tries": 3,
    "timeout_in_seconds": 3,
    "reference": "eum"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/webhook'
payload = {
    "url": "https:\/\/your-domain.com\/defichain-masternode-health\/webhook",
    "max_tries": 3,
    "timeout_in_seconds": 3,
    "reference": "eum"
}
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre>

<pre><code class="language-bash">curl --request POST \
    "https://api.defichain-masternode-health.com/v1/webhook" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"url\": \"https:\\/\\/your-domain.com\\/defichain-masternode-health\\/webhook\",
    \"max_tries\": 3,
    \"timeout_in_seconds\": 3,
    \"reference\": \"eum\"
}"
</code></pre>
</span>

<span id="example-responses-POSTv1-webhook">
</span>
<span id="execution-results-POSTv1-webhook" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTv1-webhook"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTv1-webhook"></code></pre>
</span>
<span id="execution-error-POSTv1-webhook" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTv1-webhook"></code></pre>
</span>
<form id="form-POSTv1-webhook" data-method="POST"
      data-path="v1/webhook"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTv1-webhook', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>v1/webhook</code></b>
        </p>
                <p>
            <label id="auth-POSTv1-webhook" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="POSTv1-webhook"
                                                                data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>url</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="url"
               data-endpoint="POSTv1-webhook"
               data-component="body" required  hidden>
    <br>
<p>URL receiving the webhooks. Has to be public reachable.</p>        </p>
                <p>
            <b><code>max_tries</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="max_tries"
               data-endpoint="POSTv1-webhook"
               data-component="body"  hidden>
    <br>
<p>The max tries to send the webhook to your url. (between 1..10). Default: 3</p>        </p>
                <p>
            <b><code>timeout_in_seconds</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
                <input type="number"
               name="timeout_in_seconds"
               data-endpoint="POSTv1-webhook"
               data-component="body"  hidden>
    <br>
<p>The timeout in seconds (between 1..5) Default: 3</p>        </p>
                <p>
            <b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="reference"
               data-endpoint="POSTv1-webhook"
               data-component="body"  hidden>
    <br>
<p>To assign a webhook to a specific API key, you can set an optional reference.</p>        </p>
    
    </form>

            <h2 id="webhooks-DELETEv1-webhook">Delete Webhook</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>To delete your already setup webhook just call this <code>DELETE</code> endpoint.</p>

<span id="example-requests-DELETEv1-webhook">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'https://api.defichain-masternode-health.com/v1/webhook',
    [
        'headers' =&gt; [
            'x-api-key' =&gt; 'YOUR_API_KEY',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/v1/webhook"
);

const headers = {
    "x-api-key": "YOUR_API_KEY",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>

<pre><code class="language-python">import requests
import json

url = 'https://api.defichain-masternode-health.com/v1/webhook'
headers = {
  'x-api-key': 'YOUR_API_KEY',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request DELETE \
    "https://api.defichain-masternode-health.com/v1/webhook" \
    --header "x-api-key: YOUR_API_KEY" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-DELETEv1-webhook">
</span>
<span id="execution-results-DELETEv1-webhook" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEv1-webhook"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEv1-webhook"></code></pre>
</span>
<span id="execution-error-DELETEv1-webhook" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEv1-webhook"></code></pre>
</span>
<form id="form-DELETEv1-webhook" data-method="DELETE"
      data-path="v1/webhook"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"x-api-key":"YOUR_API_KEY","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEv1-webhook', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>v1/webhook</code></b>
        </p>
                <p>
            <label id="auth-DELETEv1-webhook" hidden>x-api-key header:
                <b><code></code></b><input type="text"
                                                                name="x-api-key"
                                                                data-prefix=""
                                                                data-endpoint="DELETEv1-webhook"
                                                                data-component="header"></label>
        </p>
                </form>

        <h1 id="statistic">Statistic</h1>

    

            <h2 id="statistic-GETstatistic-last_week">Statistics last week</h2>

<p>
</p>

<p>Get usage statistics of Masternode Health of the last week.</p>

<span id="example-requests-GETstatistic-last_week">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/statistic/last_week',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/statistic/last_week"
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

url = 'https://api.defichain-masternode-health.com/statistic/last_week'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/statistic/last_week" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GETstatistic-last_week">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;data&quot;: [
        {
            &quot;date&quot;: &quot;2021-09-14&quot;,
            &quot;api_key_count&quot;: 1,
            &quot;webhook_sent_count&quot;: 0,
            &quot;request_received_count&quot;: 0
        },
        {
            &quot;date&quot;: &quot;2021-09-13&quot;,
            &quot;api_key_count&quot;: 1,
            &quot;webhook_sent_count&quot;: 0,
            &quot;request_received_count&quot;: 0
        },
        {
            &quot;date&quot;: &quot;2021-09-12&quot;,
            &quot;api_key_count&quot;: 1,
            &quot;webhook_sent_count&quot;: 0,
            &quot;request_received_count&quot;: 0
        },
        {
            &quot;date&quot;: &quot;2021-09-11&quot;,
            &quot;api_key_count&quot;: 1,
            &quot;webhook_sent_count&quot;: 0,
            &quot;request_received_count&quot;: 0
        },
        {
            &quot;date&quot;: &quot;2021-09-10&quot;,
            &quot;api_key_count&quot;: 1,
            &quot;webhook_sent_count&quot;: 0,
            &quot;request_received_count&quot;: 0
        },
        {
            &quot;date&quot;: &quot;2021-09-09&quot;,
            &quot;api_key_count&quot;: 1,
            &quot;webhook_sent_count&quot;: 0,
            &quot;request_received_count&quot;: 0
        },
        {
            &quot;date&quot;: &quot;2021-09-08&quot;,
            &quot;api_key_count&quot;: 1,
            &quot;webhook_sent_count&quot;: 0,
            &quot;request_received_count&quot;: 0
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETstatistic-last_week" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETstatistic-last_week"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETstatistic-last_week"></code></pre>
</span>
<span id="execution-error-GETstatistic-last_week" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETstatistic-last_week"></code></pre>
</span>
<form id="form-GETstatistic-last_week" data-method="GET"
      data-path="statistic/last_week"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETstatistic-last_week', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>statistic/last_week</code></b>
        </p>
                    </form>

            <h2 id="statistic-GETstatistic-all">Statistics all time</h2>

<p>
</p>

<p>Get usage statistics of Masternode Health. The data is paginated with max 25 elements per page. Switch the
page with the param <code>?page=PAGENUMMER</code>.</p>

<span id="example-requests-GETstatistic-all">
<blockquote>Example request:</blockquote>


<pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://api.defichain-masternode-health.com/statistic/all',
    [
        'headers' =&gt; [
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "https://api.defichain-masternode-health.com/statistic/all"
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

url = 'https://api.defichain-masternode-health.com/statistic/all'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre>

<pre><code class="language-bash">curl --request GET \
    --get "https://api.defichain-masternode-health.com/statistic/all" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>
</span>

<span id="example-responses-GETstatistic-all">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;date&quot;: &quot;2021-09-14&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-13&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-12&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-11&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-10&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-09&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-08&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-07&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-06&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-05&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-04&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-03&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-02&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-09-01&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-31&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-30&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-29&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-28&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-27&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-26&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-25&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-24&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-23&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-22&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            },
            {
                &quot;date&quot;: &quot;2021-08-21&quot;,
                &quot;api_key_count&quot;: 1,
                &quot;webhook_sent_count&quot;: 0,
                &quot;request_received_count&quot;: 0
            }
        ]
    },
    &quot;links&quot;: {
        &quot;first&quot;: &quot;https://api.defichain-masternode-health.com/statistic/all?page=1&quot;,
        &quot;last&quot;: &quot;https://api.defichain-masternode-health.com/statistic/all?page=2&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;https://api.defichain-masternode-health.com/statistic/all?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 2,
        &quot;path&quot;: &quot;https://api.defichain-masternode-health.com/statistic/all&quot;,
        &quot;per_page&quot;: 25,
        &quot;to&quot;: 25,
        &quot;total&quot;: 30
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETstatistic-all" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETstatistic-all"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETstatistic-all"></code></pre>
</span>
<span id="execution-error-GETstatistic-all" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETstatistic-all"></code></pre>
</span>
<form id="form-GETstatistic-all" data-method="GET"
      data-path="statistic/all"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETstatistic-all', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>statistic/all</code></b>
        </p>
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