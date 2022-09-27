#!/usr/bin/bash

today=$(date "+%Y%m%d%H%M%S")

cd /usr/share/nginx/html/storage/app/csv

gzip feed_furu1.tsv
mv "feed_furu1.tsv.gz" "feed_furu1_${today}.tsv.gz"
md5sum "feed_furu1_${today}.tsv.gz" | cut -d ' ' -f 1 > "done_furu1_${today}.txt"
scp "feed_furu1_${today}.tsv.gz" unisearch:/home/ukfeed/furu1/data/
scp "done_furu1_${today}.txt" unisearch:/home/ukfeed/furu1/data/
rm -f "feed_furu1_${today}.tsv.gz"
rm -f "done_furu1_${today}.txt"

gzip feed_furu1_campaign.tsv
mv feed_furu1_campaign.tsv.gz feed_furu1_campaign_${today}.tsv.gz  
md5sum feed_furu1_campaign_${today}.tsv.gz | cut -d ' ' -f 1 > done_furu1_campaign_${today}.txt
scp feed_furu1_campaign_${today}.tsv.gz unisearch:/home/ukfeed/furu1/data/
scp done_furu1_campaign_${today}.txt unisearch:/home/ukfeed/furu1/data/
rm -f "feed_furu1_campaign_${today}.tsv.gz"
rm -f "done_furu1_campaign_${today}.txt"