<?php
namespace Lsw\ApiCallerBundle\Call;

/**
 * cURL based API call with request data send as GET parameters
 *
 * @author J. Cary Howell <cary.howell@gmail.com>
 */
class HttpGetXML extends CurlCall implements ApiCallInterface
{

    /**
     * {@inheritdoc}
     */
    public function generateRequestData()
    {
        if ($this->requestObject) {
            $this->requestData = '?'.http_build_query($this->requestObject);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponseData()
    {
        if($this->asAssociativeArray) {
            $xml = simplexml_load_string($this->responseData);
            $json = json_encode($xml);
            $this->responseObject = json_decode( $json, TRUE );
        } else {
            $this->responseObject = $this->responseData;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function makeRequest($curl, $options)
    {
        $url = $this->url;
        if ($this->requestData) {
            $url.= $this->requestData;
        }
        $options[CURLOPT_FOLLOWLOCATION] = false;
//        dump($url);
//        dump($options);exit;
        $curl->setopt(CURLOPT_URL, $url);
        //$curl->setopt(CURLOPT_COOKIE, "");
        $curl->setopt(CURLOPT_HTTPGET, TRUE);
        $curl->setopt(CURLOPT_FOLLOWLOCATION, false);
        $curl->setoptArray($options);
        $this->curlExec($curl);
    }

}
