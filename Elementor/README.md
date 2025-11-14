Elementor Custom Query: Related Posts via ACF Relationship
=========================================================

Overview
--------
This snippet adds a custom Elementor query that displays related posts
based on an ACF Relationship field. It is generic and not tied to any
specific brand, so you can reuse it across multiple projects.

Key Features
------------
- Registers a custom query for Elementor (e.g. "relatedPosts").
- Works on single posts of a specific post type.
- Uses an ACF Relationship field to define related posts.
- Keeps the manual order defined in the ACF field.
- Returns no results if no related posts are defined (no random fallback).

Requirements
------------
- WordPress
- Elementor (version that supports "Custom Query ID" in the Query settings)
- Advanced Custom Fields (ACF) with a Relationship field
- A post type where you want to show related posts (can be `post`, `page`,
  or a custom post type)

Installation
------------
1. Copy the PHP snippet into a file, for example:
   - `elementor-related-posts-query.php`
2. Place the file in one of the following:
   - A custom plugin, or
   - Your theme or child theme (e.g. in `functions.php` or an included file)
3. Make sure the file is loaded by WordPress (activate the plugin or ensure
   the theme file is included correctly).

Configuration
-------------
Inside the snippet, you will find three key parts you may need to adjust:

1. Elementor Query ID  
   - The snippet is hooked to something like:
     `elementor/query/relatedPosts`  
   - The `relatedPosts` part is the Custom Query ID you will use in Elementor.
   - You can rename this to any ID you prefer, as long as you use the same
     value later in Elementor.

2. Post type  
   - Set the post type where the query should run, for example:
     - `post`
     - `page`
     - `your_custom_post_type`
   - The snippet only runs on singular pages of this post type.

3. ACF Relationship field  
   - Set the ACF field name that stores the related posts, for example:
     - `related_posts`
     - `related_articles`
   - The field should be an ACF Relationship field attached to the same
     post type you configured above.
   - Make sure the field returns Post Objects or Post IDs.

How It Works
------------
- When viewing a single post of the configured post type, the snippet:
  - Reads the current post ID.
  - Fetches the values of the specified ACF Relationship field.
  - Tells Elementor to query only those posts as the "related posts" list.
- If the ACF Relationship field is empty or not set, the query is forced to
  return no results (to avoid random unrelated posts).
- The order in the frontend follows the manual order defined in the ACF field.

Using It in Elementor
---------------------
1. Ensure the snippet file is active and loaded in WordPress.
2. Edit the template or page with Elementor where you want to display
   related posts (for example, a single post template).
3. Add a suitable widget:
   - Posts, Loop Grid, Archive, or any widget that supports "Custom Query ID".
4. In the widget settings:
   - Go to the Query section.
   - Look for "Custom Query ID" (or similar option).
   - Enter the same ID used in the snippet, for example:
     `relatedPosts`
5. Save and preview a single post of the configured post type.
6. The widget should now display only the posts selected in the ACF
   Relationship field for that post.

Notes
-----
- No fallback posts are shown if the ACF field is empty. This is intentional,
  so you clearly see when related posts are not configured.
- You can duplicate and adapt this snippet for multiple post types or
  different ACF fields by:
  - Changing the Query ID.
  - Adjusting the post type.
  - Pointing to another ACF Relationship field.

