***[Return Index](../../README.md)***

Signature
=====================
Signature 签名验证

## 请求头参数
| 请求头  | 是否必传  |  请求头说明 |
| ------------ | ------------ | ------------ |
| yo-client-id | 是  | appld概念，区分不同客户  |
| yo-nonce  | 是  | 随机数，用于防重发攻击，缓存期间内同一个clientld使用相同的随机数时将直接拒绝请求  |
| yo-timestamp  | 是  | Unix 时间戳，用于校验请求正确性，与服务器时间相差超过一定时间时将直接拒绝请求 超过60秒  |
| yo-signature | 是  |  签名摘要 |
| yo-without  |  否 |  不需要签名的字段，多个字段用`,`连接 。`对象、数组等复杂结构字段不建议参与签名` |

## 请求流程
1. 申请clientld、secretkey `线下申请`
2. 请求时携带请求头

## 签名规则
1. 所有请求参数參与签名 不参与签名的字段放入`yo-without`头中
2. 对所有参数key进行正序排序
3. 对排序好的参数生成生成一个符合RFC3986进行URLEncode 的请求字符串，字符集 UTF8，推荐使用编程语言标准库，所有特殊字符均需编码。`queryString`
4. 将第三步生成的请求字符串 结尾拼接 上随机数和时间戳  `signaturestr = queryString.nonce.timestamp`
5. 对拼完成的字符串使用 `HMAC-SHA256` 加密算法 生成最终签名，并对签名hash进行 `base64` 加密。追加到 header［signature ］中进行接口请求

## 代码示例
### php

```php
<?php

class AuthSignature
{
    /** @var string 分配的签名密钥 */
    protected $secretKey = '4ac26f412bff1d24e127e2ee8a984b8011f78efdd72ea7e161235e4c';

    /** @var string 签名算法 */
    protected $signatureType = 'sha256';

    protected $nonce = '';

    protected $timestamp = '';

    public function __construct(string $secretKey, string $nonce, string $timestamp)
    {
        $this->secretKey = $secretKey;
        $this->timestamp = $timestamp;
        $this->nonce     = $nonce;
    }

    /**
     * 生成签名
     *
     * @param array $payload 请求参数
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/2/23 16:59
     */
    public function generate(array $payload): string
    {
        //对传入参数按key进行正序排列
        ksort($payload);
        // 格式化为 key=value& 类型的字符串
        $queryString = urlencode(http_build_query($payload));
      
        //拼接随机数和时间戳
        $signatureStr = $queryString. $this->nonce. $this->timestamp;
        //签名计算
        $hmac = hash_hmac($this->signatureType, $signatureStr, $this->secretKey);

        return base64_encode($hmac);
    }
}
```

### java
```java
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.util.Map;
import java.util.TreeMap;
import javax.crypto.Mac;
import javax.crypto.spec.SecretKeySpec;
import java.util.Base64;

public class AuthSignature {

    /** 分配的签名密钥 */
    private String secretKey;
    /** 签名算法 */
    private final String signatureType = "HmacSHA256";
    private String nonce;
    private String timestamp;

    public AuthSignature(String secretKey, String nonce, String timestamp) {
        this.secretKey = secretKey;
        this.nonce = nonce;
        this.timestamp = timestamp;
    }

    /**
     * 生成签名
     *
     * @param payload 请求参数
     * @return String
     */
    public String generate(Map<String, String> payload) throws NoSuchAlgorithmException, InvalidKeyException {
        // 对传入参数按key进行正序排列
        Map<String, String> sortedPayload = new TreeMap<>(payload);
        
        // 格式化为 key=value& 类型的字符串
        StringBuilder queryStringBuilder = new StringBuilder();
        for (Map.Entry<String, String> entry : sortedPayload.entrySet()) {
            queryStringBuilder.append(entry.getKey()).append("=").append(entry.getValue()).append("&");
        }
        String queryString = queryStringBuilder.toString();
        if (queryString.length() > 0) {
            queryString = queryString.substring(0, queryString.length() - 1);  // remove trailing '&'
        }
        
        // 拼接随机数和时间戳
        String signatureStr = queryString + this.nonce + this.timestamp;
        
        // 签名计算
        Mac hmacSha256 = Mac.getInstance(signatureType);
        SecretKeySpec secretKeySpec = new SecretKeySpec(secretKey.getBytes(), signatureType);
        hmacSha256.init(secretKeySpec);
        byte[] hmac = hmacSha256.doFinal(signatureStr.getBytes());
        
        return Base64.getEncoder().encodeToString(hmac);
    }

    public static void main(String[] args) {
        String secretKey = "4ac26f412bff1d24e127e2ee8a984b8011f78efdd72ea7e161235e4c";
        String nonce = "your_nonce_here";
        String timestamp = "your_timestamp_here";

        AuthSignature authSignature = new AuthSignature(secretKey, nonce, timestamp);

        Map<String, String> payload = new TreeMap<>();
        payload.put("key1", "value1");
        payload.put("key2", "value2");

        try {
            String signature = authSignature.generate(payload);
            System.out.println("Generated Signature: " + signature);
        } catch (NoSuchAlgorithmException | InvalidKeyException e) {
            e.printStackTrace();
        }
    }
}
```

### Js
```js
const crypto = require('crypto');

class AuthSignature {
    /**
     * @param {string} secretKey 分配的签名密钥
     * @param {string} nonce 随机数
     * @param {string} timestamp 时间戳
     */
    constructor(secretKey, nonce, timestamp) {
        this.secretKey = secretKey;
        this.nonce = nonce;
        this.timestamp = timestamp;
    }

    /**
     * 生成签名
     *
     * @param {Object} payload 请求参数
     * @returns {string}
     */
    generate(payload) {
        // 对传入参数按key进行正序排列
        const sortedPayload = Object.keys(payload).sort().reduce((acc, key) => {
            acc[key] = payload[key];
            return acc;
        }, {});

        // 格式化为 key=value& 类型的字符串
        const queryString = new URLSearchParams(sortedPayload).toString();

        // 拼接随机数和时间戳
        const signatureStr = `${queryString}${this.nonce}${this.timestamp}`;

        // 签名计算
        const hmac = crypto.createHmac('sha256', this.secretKey).update(signatureStr).digest('base64');

        return hmac;
    }
}

// 示例
const secretKey = '4ac26f412bff1d24e127e2ee8a984b8011f78efdd72ea7e161235e4c';
const nonce = 'your_nonce_here';
const timestamp = 'your_timestamp_here';

const authSignature = new AuthSignature(secretKey, nonce, timestamp);

const payload = {
    key1: 'value1',
    key2: 'value2'
};

const signature = authSignature.generate(payload);
console.log(`Generated Signature: ${signature}`);

```

### Go
```go
package main

import (
	"crypto/hmac"
	"crypto/sha256"
	"encoding/base64"
	"fmt"
	"net/url"
	"sort"
	"strings"
)

// AuthSignature struct
type AuthSignature struct {
	// 分配的签名密钥
	secretKey string
	// 签名算法
	signatureType string
	nonce         string
	timestamp     string
}

// NewAuthSignature creates a new AuthSignature instance
func NewAuthSignature(secretKey, nonce, timestamp string) *AuthSignature {
	return &AuthSignature{
		secretKey:     secretKey,
		signatureType: "sha256",
		nonce:         nonce,
		timestamp:     timestamp,
	}
}

// Generate generates the signature
func (a *AuthSignature) Generate(payload map[string]string) string {
	// 对传入参数按key进行正序排列
	keys := make([]string, 0, len(payload))
	for k := range payload {
		keys = append(keys, k)
	}
	sort.Strings(keys)

	// 格式化为 key=value& 类型的字符串
	var queryParams []string
	for _, key := range keys {
		queryParams = append(queryParams, fmt.Sprintf("%s=%s", key, payload[key]))
	}
	queryString := strings.Join(queryParams, "&")

	// 拼接随机数和时间戳
	signatureStr := fmt.Sprintf("%s%s%s", queryString, a.nonce, a.timestamp)

	// 签名计算
	h := hmac.New(sha256.New, []byte(a.secretKey))
	h.Write([]byte(signatureStr))
	signature := base64.StdEncoding.EncodeToString(h.Sum(nil))

	return signature
}

func main() {
	secretKey := "4ac26f412bff1d24e127e2ee8a984b8011f78efdd72ea7e161235e4c"
	nonce := "your_nonce_here"
	timestamp := "your_timestamp_here"

	authSignature := NewAuthSignature(secretKey, nonce, timestamp)

	payload := map[string]string{
		"key1": "value1",
		"key2": "value2",
	}

	signature := authSignature.Generate(payload)
	fmt.Println("Generated Signature:", signature)
}

```


***[Return Index](../../README.md)***