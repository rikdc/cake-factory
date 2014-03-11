def run_phpspec

  file = nil

  unless ARGV[1].nil?
    file = "spec/#{ARGV[1]}Spec.php"
  end

  command = "`which phpspec` run --format=pretty --no-code-generation -v #{file}";

  system( 'clear' )
  system( command )

end

watch( '.*\.php' )  { |data| run_phpspec }
