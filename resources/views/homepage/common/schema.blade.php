 <script type="application/ld+json">
     {
         "@context": "https://schema.org/",
         "@type": "CreativeWorkSeries",
         "name": "<?php echo isset($seo['meta_title']) ? $seo['meta_title'] : $fcSystem['seo_meta_title']; ?>",
         "aggregateRating": {
             "@type": "AggregateRating",
             "ratingValue": "5",
             "bestRating": "5",
             "ratingCount": "16"
         }
     }
 </script>
 <script type="application/ld+json">
     {
         "@context": "https://schema.org",
         "@graph": [{
             "@type": "WebSite",
             "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#website",
             "url": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>",
             "name": "<?php echo $fcSystem['homepage_company'] ?>",
             "description": "<?php echo isset($seo['meta_description']) ? $seo['meta_description'] : $fcSystem['seo_meta_description']; ?>",
             "potentialAction": [{
                 "@type": "SearchAction",
                 "target": {
                     "@type": "EntryPoint",
                     "urlTemplate": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>?s={search_term_string}"
                 },
                 "query-input": "required name=search_term_string"
             }],
             "inLanguage": "vi"
         }, {
             "@type": "ImageObject",
             "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#primaryimage",
             "inLanguage": "vi",
             "url": "<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image'])) ? url($seo['meta_image']) : url($fcSystem['seo_meta_images']) ?>",
             "contentUrl": "<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image'])) ? url($seo['meta_image']) : url($fcSystem['seo_meta_images']) ?>",
             "width": 932,
             "height": 680
         }, {
             "@type": "WebPage",
             "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#webpage",
             "url": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>",
             "name": "Lorem ipsum dolor sit amet - <?php echo $fcSystem['homepage_company'] ?>",
             "isPartOf": {
                 "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#website"
             },
             "primaryImageOfPage": {
                 "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#primaryimage"
             },
             "author": {
                 "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#/schema/person/6923a1ffbe49cb2449ae873dc7254c27"
             },
             "breadcrumb": {
                 "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#breadcrumb"
             },
             "inLanguage": "vi",
             "potentialAction": [{
                 "@type": "ReadAction",
                 "target": ["<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>"]
             }]
         }, {
             "@type": "BreadcrumbList",
             "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#breadcrumb",
             "itemListElement": [{
                 "@type": "ListItem",
                 "position": 1,
                 "name": "Trang chủ",
                 "item": "<?php echo url(''); ?>"
             }, {
                 "@type": "ListItem",
                 "position": 2,
                 "name": "<?php echo isset($seo['meta_title']) ? $seo['meta_title'] : $fcSystem['seo_meta_title']; ?>"
             }]
         }]
     }
 </script>