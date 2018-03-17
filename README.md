# App Engine PHP Imageserver

This package is an ultralight PHP wrapper for the Google Image server. 

It can access images in stored in a dedicated GCS bucket and return you an image-serving URL. With the URL you can generate different sizes and variants on the fly (for free) all powered by the underlying Google service.

## Installation

**Important notice**

Before you continue please make sure you already have a Google Project in your [Google Cloud Console](https://console.cloud.google.com/home/dashboard). If you don't have a project please create one now. 
It may be necessary to enable billing by submitting a credit card to your account.

### 1. Configure image server source code

- Clone this repo
```bash
git clone https://github.com/makeabledk/laravel-cloud-images.git
```
- Open `index.php`
- Fill in your Google Project ID around `line 17`
```php
$app['bucket_name'] = 'YOUR-PROJECT_ID.appspot.com'; // ie. project-xyz.appspot.com
```
You can find your project-id under the panel `Project info` on the project dashboard.


### 2. Install gcloud on your maching

Follow instructions from [https://cloud.google.com/sdk/](https://cloud.google.com/sdk/)


### 3. Deploy to App Engine

We are now ready to deploy the image server to our Google App Engine.

The following code will *deploy an App Engine instance* and *create two Google Storage buckets*. 

```
composer install
gcloud config set project YOUR-PROJECT-ID # ie. project-xyz
gcloud app deploy
gcloud app browse
```
The last command will open the project in your browser - something like: `https://project-xyz.appspot.com/`


## Usage

### Upload images

1. Navigate to the **Storage** section in your Google Console. Upload any image file and copy the filename.
2. Apply the image filename (or path) to the app-engine url like: https://YOUR-PROJECT_ID.appspot.com/?image=image.jpg
3. The app-engine service should now return your imageserving URL which you can store and use to manipulate the image on-the-fly

### Serving the image

Now that you have an image serving url you can generate different versions just by changing some parameters:

**Max dimension 200px:** 

https://lh3.googleusercontent.com/nVlGxZ1Gjz_FP_xjbqTFDZtT4mM6LpqNUlqf-FR5yOpuzfYckoFdpS66HBKVJkUCycFqP7pFJkFUKnE88cGj5ZlGrg=s200 

![Example image 200px](https://lh3.googleusercontent.com/nVlGxZ1Gjz_FP_xjbqTFDZtT4mM6LpqNUlqf-FR5yOpuzfYckoFdpS66HBKVJkUCycFqP7pFJkFUKnE88cGj5ZlGrg=s200)

**Cropped to 400x150px:** 

https://lh3.googleusercontent.com/nVlGxZ1Gjz_FP_xjbqTFDZtT4mM6LpqNUlqf-FR5yOpuzfYckoFdpS66HBKVJkUCycFqP7pFJkFUKnE88cGj5ZlGrg=n-w400-h150

![Example image cropped 400x150px](https://lh3.googleusercontent.com/nVlGxZ1Gjz_FP_xjbqTFDZtT4mM6LpqNUlqf-FR5yOpuzfYckoFdpS66HBKVJkUCycFqP7pFJkFUKnE88cGj5ZlGrg=n-w400-h150)




https://lh3.googleusercontent.com/nVlGxZ1Gjz_FP_xjbqTFDZtT4mM6LpqNUlqf-FR5yOpuzfYckoFdpS66HBKVJkUCycFqP7pFJkFUKnE88cGj5ZlGrg=n-w1150-h350

4. Parametrer kan findes her: http://stackoverflow.com/questions/25148567/list-of-all-the-app-engine-images-service-get-serving-url-uri-options


## Parametrer
```
SIZE / CROP

s640 — generates image 640 pixels on largest dimension
s0 — original size image
w100 — generates image 100 pixels wide
h100 — generates image 100 pixels tall
s (without a value) — stretches image to fit dimensions
c — crops image to provided dimensions
n — same as c, but crops from the center
p — smart square crop, attempts cropping to faces
pp — alternate smart square crop, does not cut off faces (?)
cc — generates a circularly cropped image
ci — square crop to smallest of: width, height, or specified =s parameter
nu — no-upscaling. Disables resizing an image to larger than its original resolution.
PAN AND ZOOM

x, y, z: — pan and zoom a tiled image. These have no effect on an untiled image or without an authorization parameter of some form (see googleartproject.com).
ROTATION

fv — flip vertically
fh — flip horizontally
r{90, 180, 270} — rotates image 90, 180, or 270 degrees clockwise
IMAGE FORMAT

rj — forces the resulting image to be JPG
rp — forces the resulting image to be PNG
rw — forces the resulting image to be WebP
rg — forces the resulting image to be GIF
v{0,1,2,3} — sets image to a different format option (works with JPG and WebP)
Forcing PNG, WebP and GIF outputs can work in combination with circular crops for a transparent background. Forcing JPG can be combined with border color to fill in backgrounds in transparent images.

ANIMATED GIFs

rh — generates an MP4 from the input image
k — kill animation (generates static image)
MISC.

b10 — add a 10px border to image
c0xAARRGGBB — set border color, eg. =c0xffff0000 for red
d — adds header to cause browser download
e7 — set cache-control max-age header on response to 7 days
l100 — sets JPEG quality to 100% (1-100)
h — responds with an HTML page containing the image
g — responds with XML used by Google's pan/zoom
Filters

fSoften=1,100,0: - where 100 can go from 0 to 100 to blur the image
fVignette=1,100,1.4,0,000000 where 100 controls the size of the gradient and 000000 is RRGGBB of the color of the border shadow
fInvert=0,1 inverts the image regardless of the value provided
fbw=0,1 makes the image black and white regardless of the value provided
```