<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mailcoach_email_lists', function (Blueprint $table) {
            $table->unique('uuid');

            $table->foreignId('confirmation_mail_id')->after('requires_confirmation')->nullable();

            $table->after('allowed_form_extra_attributes', function (Blueprint $table) {
                $table->string('honeypot_field')->nullable();
                $table->boolean('has_website')->default(false);
                $table->boolean('show_subscription_form_on_website')->default(true);
                $table->string('website_slug')->nullable();
                $table->string('website_title')->nullable();
                $table->text('website_intro')->nullable();
                $table->string('website_primary_color')->nullable();
                $table->string('website_theme')->default('default');
                $table->text('website_subscription_description')->nullable();
            });

            $table->dropColumn([
                'confirmation_mail_subject',
                'confirmation_mail_content',
                'send_welcome_mail',
                'welcome_mail_subject',
                'welcome_mail_content',
                'welcome_mailable_class',
                'welcome_mail_delay_in_minutes',
            ]);
        });

        Schema::table('mailcoach_subscribers', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_segments', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_segments')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_segments', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->unique('uuid');
            $table->index('sent_at');
            $table->index(['scheduled_at', 'status']);

            $table->boolean('show_publicly')->after('subject')->default(true);
            $table->unsignedBigInteger('template_id')->after('email_list_id')->nullable();

            $table->after('segment_description', function (Blueprint $table) {
                $table->boolean('add_subscriber_tags')->default(false);
                $table->boolean('add_subscriber_link_tags')->default(false);
            });

            $table->dropColumn([
                'track_opens',
                'track_clicks',
            ]);
        });

        Schema::table('mailcoach_campaign_links', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
        });
        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_campaign_links')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }
        Schema::table('mailcoach_campaign_links', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::rename('mailcoach_transactional_mails', 'mailcoach_transactional_mail_log_items');
        Schema::table('mailcoach_transactional_mail_log_items', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
            $table->json('attachments')->after('bcc')->nullable();

            $table->dropColumn([
                'track_opens',
                'track_clicks',
            ]);
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_transactional_mail_log_items')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_transactional_mail_log_items', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_automation_mails', function (Blueprint $table) {
            $table->unique('uuid');
            $table->unsignedBigInteger('template_id')->after('subject')->nullable();

            $table->after('utm_tags', function (Blueprint $table) {
                $table->boolean('add_subscriber_tags')->default(false);
                $table->boolean('add_subscriber_link_tags')->default(false);
            });

            $table->dropColumn([
                'track_opens',
                'track_clicks',
            ]);
        });

        Schema::table('mailcoach_sends', function (Blueprint $table) {
            $table->renameColumn('transactional_mail_id', 'transactional_mail_log_item_id');
            $table->timestamp('invalidated_at')->after('sent_at')->nullable();

            $table->index('transport_message_id');
            $table->index(['sending_job_dispatched_at', 'sent_at'], 'sent_index');
        });

        Schema::table('mailcoach_campaign_clicks', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_campaign_clicks')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_campaign_clicks', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_campaign_opens', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_campaign_opens')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_campaign_opens', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_campaign_unsubscribes', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_campaign_unsubscribes')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_campaign_unsubscribes', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_send_feedback_items', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_send_feedback_items')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_send_feedback_items', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_templates', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
            $table->boolean('contains_placeholders')->after('name')->default(false);
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_templates')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_templates', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_subscriber_imports', function (Blueprint $table) {
            $table->unique('uuid');
            $table->text('errors')->after('imported_subscribers_count')->nullable();

            $table->dropColumn('error_count');
        });

        Schema::table('mailcoach_tags', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
            $table->boolean('visible_in_preferences')->after('type')->default(false);
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_tags')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_tags', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_email_list_subscriber_tags', function (Blueprint $table) {
            $table->index(['subscriber_id', 'tag_id'], 'subscriber_id_tag_id_index');
        });

        Schema::table('mailcoach_automations', function (Blueprint $table) {
            $table->unique('uuid');

            $table->after('interval', function (Blueprint $table) {
                $table->boolean('repeat_enabled')->default(false);
                $table->boolean('repeat_only_after_halt')->default(true);
            });
        });

        Schema::table('mailcoach_automation_actions', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_automation_triggers', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_automation_action_subscriber', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');

            $table->index('action_id');
            $table->index('subscriber_id');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_automation_action_subscriber')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_automation_action_subscriber', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_automation_mail_opens', function (Blueprint $table) {
            $table->uuid('uuid');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_automation_mail_opens')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_automation_mail_opens', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_automation_mail_links', function (Blueprint $table) {
            $table->uuid('uuid');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_automation_mail_links')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_automation_mail_links', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_automation_mail_clicks', function (Blueprint $table) {
            $table->uuid('uuid');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_automation_mail_clicks')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_automation_mail_clicks', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_automation_mail_unsubscribes', function (Blueprint $table) {
            $table->uuid('uuid');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_automation_mail_unsubscribes')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_automation_mail_unsubscribes', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_transactional_mail_opens', function (Blueprint $table) {
            $table->uuid('uuid')->index();
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_transactional_mail_opens')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_transactional_mail_opens', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::table('mailcoach_transactional_mail_clicks', function (Blueprint $table) {
            $table->uuid('uuid');
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_transactional_mail_clicks')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_transactional_mail_clicks', function (Blueprint $table) {
            $table->unique('uuid');
        });

        Schema::rename('mailcoach_transactional_mail_templates', 'mailcoach_transactional_mails');
        Schema::table('mailcoach_transactional_mails', function (Blueprint $table) {
            $table->uuid('uuid')->after('id');
            $table->unsignedBigInteger('template_id')->after('bcc')->nullable();

            $table->dropColumn([
                'track_opens',
                'track_clicks',
            ]);
        });

        if (!app()->runningUnitTests()) {
            DB::table('mailcoach_transactional_mails')->update([
                'uuid' => DB::raw('uuid()'),
            ]);
        }

        Schema::table('mailcoach_transactional_mails', function (Blueprint $table) {
            $table->unique('uuid');
        });

        if (! Schema::hasColumn('users', 'welcome_valid_until')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('welcome_valid_until')->nullable();
            });
        }

        if (! Schema::hasTable('mailcoach_uploads')) {
            Schema::create('mailcoach_uploads', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')->unique();
                $table->timestamps();
            });
        } else {
            Schema::table('mailcoach_uploads', function (Blueprint $table) {
                $table->uuid('uuid')->after('id');
            });

            if (!app()->runningUnitTests()) {
                DB::table('mailcoach_uploads')->update([
                    'uuid' => DB::raw('uuid()'),
                ]);
            }

            Schema::table('mailcoach_uploads', function (Blueprint $table) {
                $table->unique('uuid');
            });
        }

        if (! Schema::hasTable('mailcoach_settings')) {
            Schema::create('mailcoach_settings', function (Blueprint $table) {
                $table->string('key')->index();
                $table->longText('value')->nullable();
            });
        }

        Schema::create('mailcoach_mailers', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->string('config_key_name')->index();
            $table->string('transport');
            $table->longText('configuration')->nullable();
            $table->boolean('default')->default(false);
            $table->boolean('ready_for_use')->default(false);
            $table->timestamps();
        });

        Schema::create('mailcoach_webhook_configurations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->text('url');
            $table->string('secret');
            $table->boolean('use_for_all_lists')->default(true);
            $table->timestamps();
        });

        Schema::create('mailcoach_webhook_configuration_email_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webhook_configuration_id');
            $table->unsignedBigInteger('email_list_id');
            $table->timestamps();

            $table
                ->foreign('webhook_configuration_id', 'wc_idx')
                ->references('id')->on('mailcoach_webhook_configurations')
                ->cascadeOnDelete();

            $table
                ->foreign('email_list_id', 'mel_idx')
                ->references('id')->on('mailcoach_email_lists')
                ->cascadeOnDelete();
        });

        if (! Schema::hasColumn('personal_access_tokens', 'expires_at')) {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->timestamp('expires_at')->after('last_used_at')->nullable();
            });
        }
    }
};
