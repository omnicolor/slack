# Header

A larger, bolded bit of text.

```php
use Omnicolor\Slack\Response;
use Omnicolor\Slack\Headers\Header;

$response = (new Response())
    ->addBlock(new Header'This is a header block'));
echo json_encode($response);
```
Will produce this output:
```json
{
	"blocks": [
		{
			"type": "header",
			"text": {
				"type": "plain_text",
				"text": "This is a header block",
				"emoji": true
			}
		}
	],
    "response_type": "ephemeral"
}
```

And a Slack client will render it like:
![Screenshot of a header.](../images/headers/header.png)
