FROM cassandra

COPY entrypoint-wrap.sh /entrypoint-wrap.sh

RUN apt-get update && apt-get install -y dos2unix
RUN dos2unix /entrypoint-wrap.sh && apt-get --purge remove -y dos2unix && rm -rf /var/lib/apt/lists/*

ENTRYPOINT ["/entrypoint-wrap.sh"]
CMD ["cassandra", "-f"]