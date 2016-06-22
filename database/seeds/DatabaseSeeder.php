<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

       // $this->call(UserTableSeeder::class);
        

        $this->call('AdminSeeder');
        $this->command->info('Admin table seeded!');

        $this->call('CountrySeeder');
        $this->command->info('Country table seeded!');

        
        
        $this->call('StateSeeder');
        $this->command->info('State table seeded!');

        
        
        $this->call('CurrencySeeder');
        $this->command->info('Currency table seeded!');

        $this->call('SalutationSeeder');
        $this->command->info('Salutation table seeded!');

        $this->call('ServiceSeeder');
        $this->command->info('Service table seeded!');

        $this->call('ServiceTaxClassSeeder');
        $this->command->info('ServiceTaxClass table seeded!');

        $this->call('MembershipSeeder');
        $this->command->info('Membership table seeded!');

        $this->call('AddressTypeSeeder');
        $this->command->info('AddressType table seeded!');

        $this->call('CsiRegionSeeder');
        $this->command->info('CsiRegion table seeded!');

        

        $this->call('CsiStateSeeder');
        $this->command->info('CsiState table seeded!');

        

        $this->call('CsiChapterSeeder');
        $this->command->info('CsiChapter table seeded!');

        $this->call('MembershipTypeSeeder');
        $this->command->info('MembershipType table seeded!');

        $this->call('MembershipPeriodSeeder');
        $this->command->info('MembershipPeriod table seeded!');

        $this->call('InstitutionTypeSeeder');
        $this->command->info('InstitutionType table seeded!');

        $this->call('PaymentModeSeeder');
        $this->command->info('PaymentMode table seeded!');

        $this->call('PaymentHeadSeeder');
        $this->command->info('PaymentHead table seeded!');

        $this->call('NotificationTypeSeeder');
        $this->command->info('NotificationType table seeded!');
            
            
        $this->call('EventTypeSeeder');
        $this->command->info('EventType table seeded!'); 


         $this->call('TargetAudienceSeeder');
        $this->command->info('TargetAudience table seeded!');

        $this->call('EventStatusSeeder');
        $this->command->info('EventStatus table seeded!');

        $this->call('EventRequestAdminDecisionSeeder');
        $this->command->info('EventRequestAdminDecision table seeded!');

        $this->call('EventGrantTypeSeeder');
        $this->command->info('EventGrantType table seeded!'); 

        $this->call('EventGrantStatusSeeder');
        $this->command->info('EventGrantStatus table seeded!');
        
        Model::reguard();
    }
}
