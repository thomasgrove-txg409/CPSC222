#!/usr/bin/perl
use strict;
use warnings;
use Getopt::Long;

my $show_all = 0;
GetOptions('a' => \$show_all);

my $logfile = '/var/log/auth.log';
exit 0 unless -r $logfile;

open(my $fh, '<', $logfile) or die "Cannot open $logfile: $!";

my @arrsudo;

while (my $line = <$fh>) {
    # Flexible regex for ISO 8601 timestamp lines
    if ($line =~ /^
        (\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2})  # datetime
        \.\d+[-+]\d{2}:\d{2}\s+\S+\s+sudo:\s+  # skip microseconds and host
        \s*([\w\-]+)\s*:                        # source user
        .*USER=([\w\-]+)                        # target user
    /x) {
        my ($datetime, $src, $dst) = ($1, $2, $3);
        # Only push if all three values are defined
        next unless defined $datetime && defined $src && defined $dst;
        $datetime =~ s/T/ /;  # replace T with space for readability
        push @arrsudo, {
            datetime => $datetime,
            src      => $src,
            dst      => $dst
        };
    }
}

close($fh);

if ($show_all) {
    printf "%-20s %-15s %-15s\n", "DATE / TIME", "SOURCE USER", "TARGET USER";
    printf "%-20s %-15s %-15s\n", "-" x 20, "-" x 15, "-" x 15;

    foreach my $entry (@arrsudo) {
        printf "%-20s %-15s %-15s\n",
            $entry->{datetime} // '',
            $entry->{src}      // '',
            $entry->{dst}      // '';
    }
} else {
    print scalar(@arrsudo);
}

