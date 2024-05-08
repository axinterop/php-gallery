# Photo Gallery in PHP

The application is server-side focused (minimal front-end) and is implemented in PHP language, without the use of external frameworks. The gallery allows adding new image files and viewing those previously uploaded to the server. The application allows proper user registration, login and logout. The information presented on the page varies depending on whether the user is logged in or not - according to the guidelines in the following sections. The application was implemented according to the MVC pattern.

It was required to prepare runtime environment for the application. The environment constisted of Debian on VirtualBox machine, configured accordingly for needs of application: the Apache HTTP server and MongoDB were installed; some file and folder manipulation were done to connect outside development folder with internal, debian's one; some tweaks in Apache config.

The codebase is in English, however the application itself is in Polish.

# Features overview

Description of application features:
- Uploading files to the server
  - Only PNG or JPG files are allowed. They cannot exceed 1 MB in size.
  - During the upload, user is required to enter watermark text. On server side, text is applied to the original photo. Simultaneously, thumbnail (small resolution copy of original without watermark) is created.
- Gallery of uploaded images
  - The gallery presents thumbnails of photos (generated during upload) on a paging basis, 3 at a time.
    Clicking on the thumbnail image redirects to the watermarked image in full size.
- User registration and login
  - During the registration user's credentials are verified and stored in MongoDB database. The password is stored as a hash.
  - During the login, user can either provide correct credentials and be logged in, or get a failure message. Logged-in user can logout.
- Use of database
  - Uploaded photos and created users are stored in MongoDB database.
- Session mechanism
  - User can select photos and, by clicking the button, "remember" them. Next time one accesses the gallery, remembered photos will be highlighted.
  - User can "forget" the photos, by going to another sub-page, selecting unwanted photos and clicking the right button.
- Distinguishing users
  - Logged-in users during image upload can choose the visibility of their photos, "public" or "private". Private photos are not visible in the gallery to other users (both logged in and anonymous), only for the user who uploaded it. Public ones are handled normally. Photos uploaded by non-logged-in users are treated as public.
- AJAX - image search engine
  - User can use a photo search engine by typing fragment of a photo title in a text field. As the user types more letters, successive asynchronous HTTP (AJAX) requests are sent to the server. Server responds in real time with thumbnails of matched photos.
